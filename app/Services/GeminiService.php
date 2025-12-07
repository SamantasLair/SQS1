<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', env('GEMINI_API_KEY'));
    }

    public function generateQuizFromText(string $text, int $pgAmount, int $essayAmount): array
    {
        $total = $pgAmount + $essayAmount;

        $prompt = "Buatkan total {$total} soal kuis berdasarkan teks materi berikut.
        
        INSTRUKSI DISTRIBUSI SOAL:
        1. Buat tepat {$pgAmount} soal Pilihan Ganda (field 'question_type': 'multiple_choice').
        2. Buat tepat {$essayAmount} soal Essay/Uraian (field 'question_type': 'essay').
        3. Jika materi kurang, gunakan PENGETAHUAN UMUM yang relevan. JANGAN MENOLAK.
        
        ATURAN FORMATTING:
        - Output WAJIB JSON murni array of objects.
        - Rumus Matematika: Bungkus dengan $. Contoh: \$x^2\$.
        - Kode Program: Bungkus dengan <pre><code>.
        - Untuk Essay, kosongkan array 'options'.
        
        STRUKTUR JSON:
        [
            {
                \"question_text\": \"Pertanyaan...\",
                \"question_type\": \"multiple_choice\", 
                \"topic\": \"Topik\",
                \"options\": [
                    {\"text\": \"A\", \"is_correct\": false},
                    {\"text\": \"B\", \"is_correct\": true}
                ]
            }
        ]
        
        Teks Materi:
        " . substr($text, 0, 30000);

        return $this->executeRequest($prompt);
    }

    public function analyzeQuizResult(array $data, string $level): string
    {
        $jsonData = json_encode($data);
        $prompt = "";

        if ($level === 'diagnostic') {
            $prompt = "Bertindaklah sebagai asisten guru. Analisis data nilai: {$jsonData}. Berikan diagnosa singkat kekuatan dan kelemahan siswa per topik.";
        } elseif ($level === 'remedial') {
            $prompt = "Bertindaklah sebagai ahli kurikulum. Data: {$jsonData}. Identifikasi topik lemah, analisis butir soal pengecoh, dan strategi remedial.";
        } elseif ($level === 'full_insight') {
            $prompt = "Bertindaklah sebagai konsultan pendidikan. Data: {$jsonData}. Berikan analisis psikometrik, pola jawaban, dan learning path.";
        }

        if (empty($prompt)) return "Analisis tidak tersedia.";

        $response = $this->executeRequest($prompt, false);
        return is_string($response) ? $response : json_encode($response);
    }

    private function executeRequest(string $prompt, bool $expectJson = true)
    {
        $model = $this->getCachedModel();
        
        try {
            $response = Http::timeout(30)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}{$model}:generateContent?key={$this->apiKey}", [
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 8192,
                    'responseMimeType' => $expectJson ? 'application/json' : 'text/plain',
                ]
            ]);

            if ($response->status() === 429) {
                sleep(2);
                return $this->executeRequest($prompt, $expectJson);
            }

            if ($response->failed()) {
                if ($response->status() === 404 || $response->status() === 400) {
                    Cache::forget('gemini_active_model');
                }
                
                Log::error('Gemini API Error: ' . $response->body());
                return $expectJson ? [] : 'Error generating content.';
            }

            $responseData = $response->json();
            $text = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            if ($expectJson) {
                $jsonString = str_replace(['```json', '```'], '', $text);
                
                $start = strpos($jsonString, '[');
                $end = strrpos($jsonString, ']');
                
                if ($start !== false && $end !== false) {
                    $jsonString = substr($jsonString, $start, ($end - $start) + 1);
                }

                $result = json_decode($jsonString, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return [];
                }

                if (is_array($result) && !array_is_list($result)) {
                    $firstKey = array_key_first($result);
                    if (is_array($result[$firstKey])) return $result[$firstKey];
                }

                return is_array($result) ? $result : [];
            }

            return $text;

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return $expectJson ? [] : 'Service unavailable.';
        }
    }

    private function getCachedModel()
    {
        return Cache::remember('gemini_active_model', 86400, function () {
            try {
                $response = Http::timeout(5)->get("{$this->baseUrl}models?key={$this->apiKey}");
                
                if ($response->successful()) {
                    $data = $response->json();
                    $models = $data['models'] ?? [];
                    $preferred = ['gemini-1.5-flash', 'gemini-1.5-pro', 'gemini-1.0-pro', 'gemini-pro'];

                    foreach ($preferred as $term) {
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
                }
            } catch (\Exception $e) {
                // Ignore
            }
            return 'models/gemini-1.5-flash';
        });
    }
}