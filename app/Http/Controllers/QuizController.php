<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    public function index(): View
    {
        $quizzes = Auth::user()->quizzes()->latest()->get();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create(): View
    {
        return view('quizzes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timer' => 'required|integer|min:1',
            'ai_prompt' => 'nullable|string',
            'document' => 'nullable|mimes:pdf|max:10240',
            'question_count' => 'nullable|integer|min:1|max:20',
            'question_type' => 'nullable|in:multiple_choice,essay',
        ]);

        $user = Auth::user();
        $isUsingAi = $request->filled('ai_prompt') || $request->hasFile('document');

        if ($isUsingAi && !$user->is_premium) {
            $today = now()->toDateString();
            
            if ($user->last_ai_usage_date !== $today) {
                $user->update([
                    'ai_usage_count' => 0,
                    'last_ai_usage_date' => $today
                ]);
            }

            if ($user->ai_usage_count >= 3) {
                return back()->with('error', 'Batas penggunaan AI harian Anda (3x) sudah habis. Upgrade ke Premium untuk akses tanpa batas.')->withInput();
            }
        }

        try {
            do {
                $code = Str::upper(Str::random(6));
            } while (Quiz::where('join_code', $code)->exists());

            $source = 'manual';
            if ($isUsingAi) {
                $source = 'ai';
            }

            $quiz = Auth::user()->quizzes()->create([
                'title' => $request->title,
                'description' => $request->description,
                'timer' => $request->timer,
                'generation_source' => $source,
                'join_code' => $code,
            ]);

            if ($source === 'ai') {
                try {
                    $this->generateQuestionsFromAi($quiz, $request);
                    
                    if (!$user->is_premium) {
                        $user->increment('ai_usage_count');
                    }

                    return redirect()->route('quizzes.edit', $quiz)
                        ->with('success', 'Kuis berhasil dibuat oleh AI.');
                } catch (\Exception $e) {
                    return redirect()->route('quizzes.edit', $quiz)
                        ->with('error', 'Kuis tersimpan, tapi AI gagal: ' . $e->getMessage());
                }
            }

            return redirect()->route('quizzes.edit', $quiz)
                ->with('success', 'Kuis berhasil dibuat.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat kuis: ' . $e->getMessage())->withInput();
        }
    }

    private function generateQuestionsFromAi(Quiz $quiz, Request $request)
    {
        $promptContext = "";
        
        if ($request->hasFile('document')) {
            if (!class_exists(Parser::class)) {
                throw new \Exception('PDF Parser belum diinstall.');
            }
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($request->file('document')->path());
                $text = Str::limit(preg_replace('/\s+/', ' ', $pdf->getText()), 12000);
                
                if (strlen($text) < 50) throw new \Exception('Teks PDF terlalu sedikit.');
                
                $promptContext .= "SOURCE MATERIAL FROM PDF:\n" . $text . "\n\n";
            } catch (\Exception $e) {
                throw new \Exception('Gagal membaca PDF: ' . $e->getMessage());
            }
        }

        if ($request->filled('ai_prompt')) {
            $promptContext .= "USER INSTRUCTION/TOPIC:\n" . $request->ai_prompt . "\n\n";
        }

        $qCount = $request->question_count ?? 10;
        $qType = $request->question_type ?? 'multiple_choice';

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) throw new \Exception('API Key Gemini tidak ditemukan.');

        $modelName = $this->getAvailableGeminiModel($apiKey);

        $finalPrompt = "You are a teacher creating a quiz. Create {$qCount} {$qType} questions based on the context provided.
        
        RULES FOR MATHEMATICS VS CODE:
        1. If the context is MATHEMATICS or PHYSICS: You MUST wrap all formulas, equations, variables, and numbers with exponents in LaTeX delimiters using single dollar signs. 
           Example: Use '\$x^2 + y^2 = z^2\$' instead of 'x^2 + y^2 = z^2'. Use '\$\\sqrt{144}\$' for roots.
        2. If the context is COMPUTER SCIENCE / PROGRAMMING / LOGIC: Do NOT use LaTeX for code syntax or logical operators unless it is a mathematical formula.
           Example: 'Use the ^ operator for XOR' (Keep as is, DO NOT wrap in dollar signs).
           Example: 'The complexity is \$O(n^2)\$' (Wrap this because it is math notation).
        3. Output format: JSON Array of Objects (RFC 8259 compatible). NO Markdown formatting (do not use ```json).
        4. Language: Indonesian.
        5. Escape backslashes in JSON properly (e.g. use '\\\\' for LaTeX commands).

        JSON Structure for multiple_choice:
        [{\"question\": \"...\", \"options\": [\"A\", \"B\", \"C\", \"D\"], \"correct_index\": 0}]
        
        JSON Structure for essay:
        [{\"question\": \"...\", \"options\": [], \"correct_index\": null}]

        CONTEXT:
        {$promptContext}";

        $url = "https://generativelanguage.googleapis.com/v1beta/{$modelName}:generateContent?key={$apiKey}";

        $response = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post($url, [
                'contents' => [['parts' => [['text' => $finalPrompt]]]],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                    'temperature' => 0.7
                ]
            ]);

        if ($response->failed()) {
            throw new \Exception("AI Error: " . $response->body());
        }

        $responseData = $response->json();
        
        if (!isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            throw new \Exception('Respon AI kosong.');
        }

        $text = $responseData['candidates'][0]['content']['parts'][0]['text'];
        
        $cleanText = preg_replace('/```json\s*|\s*```/', '', $text);
    
        $start = strpos($cleanText, '[');
        $end = strrpos($cleanText, ']');
        
        if ($start !== false && $end !== false) {
            $jsonContent = substr($cleanText, $start, ($end - $start) + 1);
        } else {
            $jsonContent = $cleanText;
        }

        $questionsData = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Gagal parsing JSON AI: ' . json_last_error_msg());
        }

        DB::transaction(function() use ($quiz, $questionsData, $qType) {
            foreach ($questionsData as $qData) {
                $question = $quiz->questions()->create([
                    'question_text' => $qData['question'],
                    'question_type' => $qType,
                ]);

                if ($qType === 'multiple_choice' && !empty($qData['options'])) {
                    foreach ($qData['options'] as $index => $optionText) {
                        $question->options()->create([
                            'option_text' => $optionText,
                            'is_correct' => isset($qData['correct_index']) && ($index === (int)$qData['correct_index']),
                        ]);
                    }
                }
            }
        });
    }

    private function getAvailableGeminiModel($apiKey)
    {
        $response = Http::get("[https://generativelanguage.googleapis.com/v1beta/models?key=](https://generativelanguage.googleapis.com/v1beta/models?key=){$apiKey}");
        if ($response->failed()) return 'models/gemini-1.5-flash';

        $data = $response->json();
        $models = $data['models'] ?? [];
        $preferredTerms = ['flash', 'pro', 'gemini-1.5', 'gemini-1.0'];

        foreach ($preferredTerms as $term) {
            foreach ($models as $model) {
                if (isset($model['name']) && 
                    in_array('generateContent', $model['supportedGenerationMethods'] ?? []) &&
                    str_contains($model['name'], $term)) {
                    return $model['name'];
                }
            }
        }
        
        foreach ($models as $model) {
            if (in_array('generateContent', $model['supportedGenerationMethods'] ?? [])) {
                return $model['name'];
            }
        }

        return 'models/gemini-pro';
    }

    public function show(Quiz $quiz): View
    {
        if ($quiz->user_id !== Auth::id()) abort(403);
        $quiz->load(['questions.options']);
        return view('quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz): View
    {
        if ($quiz->user_id !== Auth::id()) abort(403);
        $quiz->load(['questions.options']);
        return view('quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz): RedirectResponse
    {
        if ($quiz->user_id !== Auth::id()) abort(403);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'timer' => 'required|integer|min:1',
            'questions' => 'nullable|array',
            'questions.*.text' => 'required|string',
            'questions.*.question_type' => 'required|in:multiple_choice,essay',
        ]);

        DB::transaction(function () use ($request, $quiz) {
            $quiz->update($request->only('title', 'description', 'timer'));

            $inputQuestions = $request->questions ?? [];
            $inputQuestionIds = collect($inputQuestions)->pluck('id')->filter()->toArray();
            
            $quiz->questions()->whereNotIn('id', $inputQuestionIds)->delete();

            foreach ($inputQuestions as $qData) {
                $question = $quiz->questions()->updateOrCreate(
                    ['id' => $qData['id'] ?? null],
                    [
                        'question_text' => $qData['text'],
                        'question_type' => $qData['question_type']
                    ]
                );

                if ($qData['question_type'] === 'multiple_choice' && isset($qData['options'])) {
                    $inputOptions = $qData['options'];
                    $inputOptionIds = collect($inputOptions)->pluck('id')->filter()->toArray();
                    
                    $question->options()->whereNotIn('id', $inputOptionIds)->delete();

                    foreach ($inputOptions as $oIndex => $oData) {
                        $question->options()->updateOrCreate(
                            ['id' => $oData['id'] ?? null],
                            [
                                'option_text' => $oData['text'],
                                'is_correct' => isset($qData['correct_option']) && (int)$qData['correct_option'] == $oIndex
                            ]
                        );
                    }
                } else {
                    $question->options()->delete();
                }
            }
        });

        return redirect()->route('quizzes.show', $quiz)->with('success', 'Kuis berhasil diperbarui.');
    }

    public function destroy(Quiz $quiz): RedirectResponse
    {
        if ($quiz->user_id !== Auth::id()) abort(403);
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Kuis dihapus.');
    }

    public function destroyQuestion(Question $question): RedirectResponse
    {
        if ($question->quiz->user_id !== Auth::id()) abort(403);
        $question->delete();
        return back()->with('success', 'Soal berhasil dihapus.');
    }

    public function leaderboard(Quiz $quiz): View
    {
        $attempts = $quiz->attempts()->with('user')->orderByDesc('score')->paginate(10);
        return view('quizzes.leaderboard', compact('quiz', 'attempts'));
    }
}