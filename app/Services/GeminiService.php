<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', env('GEMINI_API_KEY'));
    }

    public function generateQuizFromText(string $text, int $amount = 5): array
    {
        $prompt = "Buatkan {$amount} soal kuis pilihan ganda berdasarkan teks berikut. 
        Format output WAJIB JSON murni tanpa markdown ```json atau kata-kata tambahan.
        Struktur JSON array object:
        [
            {
                \"question\": \"Pertanyaan\",
                \"options\": [
                    {\"text\": \"Pilihan A\", \"is_correct\": false},
                    {\"text\": \"Pilihan B\", \"is_correct\": true},
                    {\"text\": \"Pilihan C\", \"is_correct\": false},
                    {\"text\": \"Pilihan D\", \"is_correct\": false}
                ]
            }
        ]
        
        Teks Materi:
        " . substr($text, 0, 30000);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}?key={$this->apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 8192,
                ]
            ]);

            if ($response->failed()) {
                Log::error('Gemini API Error: ' . $response->body());
                return [];
            }

            $responseData = $response->json();
            $generatedText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            $jsonString = str_replace(['```json', '```'], '', $generatedText);
            $questions = json_decode($jsonString, true);

            return is_array($questions) ? $questions : [];

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return [];
        }
    }
}