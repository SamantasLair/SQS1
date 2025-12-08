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

        return $this->executeRequest([['text' => $prompt]]);
    }

    public function generateQuizFromImage(string $imagePath, int $pgAmount, int $essayAmount): array
    {
        $total = $pgAmount + $essayAmount;
        
        $imageData = base64_encode(file_get_contents($imagePath));
        $mimeType = mime_content_type($imagePath);

        $promptText = "Buatkan total {$total} soal kuis berdasarkan GAMBAR yang dilampirkan.
        
        INSTRUKSI DISTRIBUSI SOAL:
        1. Buat tepat {$pgAmount} soal Pilihan Ganda (field 'question_type': 'multiple_choice').
        2. Buat tepat {$essayAmount} soal Essay/Uraian (field 'question_type': 'essay').
        3. Analisis gambar dengan teliti (teks, diagram, atau objek).
        
        ATURAN FORMATTING:
        - Output WAJIB JSON murni array of objects.
        
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
        ]";

        $parts = [
            ['text' => $promptText],
            [
                'inline_data' => [
                    'mime_type' => $mimeType,
                    'data' => $imageData
                ]
            ]
        ];

        return $this->executeRequest($parts);
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

        $response = $this->executeRequest([['text' => $prompt]], false);
        return is_string($response) ? $response : json_encode($response);
    }

    private function executeRequest(array $parts, bool $expectJson = true, int $retryCount = 0)
    {
        $model = $this->getCachedModel();
        
        $url = "{$this->baseUrl}{$model}:generateContent?key={$this->apiKey}";
        
        $payload = [
            'contents' => [['parts' => $parts]],
            'generationConfig' => [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 8192,
                'responseMimeType' => $expectJson ? 'application/json' : 'text/plain',
            ]
        ];

        $startTime = microtime(true);
        Log::info('GEMINI REQUEST START', [
            'url' => $url,
            'model' => $model,
            'retry' => $retryCount,
            'expect_json' => $expectJson
        ]);

        try {
            $response = Http::timeout(60)->withHeaders([
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            $duration = microtime(true) - $startTime;
            
            Log::info('GEMINI REQUEST END', [
                'duration' => round($duration, 2) . 's',
                'status' => $response->status(),
                'body_snippet' => substr($response->body(), 0, 500)
            ]);

            if ($response->status() === 429) {
                if ($retryCount < 3) {
                    $sleepTime = pow(2, $retryCount + 1); 
                    Log::warning("GEMINI RATE LIMIT HIT. Sleeping for {$sleepTime}s...");
                    sleep($sleepTime);
                    return $this->executeRequest($parts, $expectJson, $retryCount + 1);
                } else {
                    Log::error('GEMINI RATE LIMIT EXCEEDED AFTER RETRIES');
                    return $expectJson ? [] : 'Layanan AI sedang sibuk (Rate Limit). Silakan coba lagi nanti.';
                }
            }

            if ($response->failed()) {
                if ($response->status() === 404 || $response->status() === 400) {
                    Cache::forget('gemini_active_model');
                }
                
                Log::error('GEMINI API FAILED', ['body' => $response->body()]);
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
                    Log::error('GEMINI JSON PARSE ERROR', ['json_error' => json_last_error_msg(), 'raw_text' => $text]);
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
            Log::error('GEMINI CRITICAL EXCEPTION', ['message' => $e->getMessage()]);
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
                    
                    $preferred = [
                        'gemini-2.5-flash', 
                        'gemini-2.5-flash-lite',
                        'gemini-2.0-flash', 
                        'gemini-2.0-flash-exp', 
                        'gemini-1.5-flash'
                    ];

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
            }
            
            return 'models/gemini-2.5-flash'; 
        });
    }
}