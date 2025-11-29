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
        $prompt = "Buatkan {$amount} soal kuis (bisa pilihan ganda atau essay) berdasarkan teks berikut. 
        Sertakan field 'topic' (1-2 kata) untuk setiap soal yang menggambarkan sub-bab materi tersebut.
        Format output WAJIB JSON murni tanpa markdown ```json.
        Struktur JSON array object:
        [
            {
                \"question_text\": \"Pertanyaan\",
                \"question_type\": \"multiple_choice\", 
                \"topic\": \"Aljabar\",
                \"options\": [
                    {\"text\": \"Pilihan A\", \"is_correct\": false},
                    {\"text\": \"Pilihan B\", \"is_correct\": true}
                ]
            }
        ]
        
        Teks Materi:
        " . substr($text, 0, 30000);

        return $this->makeRequest($prompt);
    }

    public function analyzeQuizResult(array $data, string $level): string
    {
        $prompt = "";
        $jsonData = json_encode($data);

        if ($level === 'diagnostic') {
            $prompt = "Bertindaklah sebagai asisten guru. Analisis data nilai siswa berikut: {$jsonData}. 
            Berikan laporan singkat per siswa tentang kekuatan dan kelemahan mereka berdasarkan topik soal (field 'topic'). 
            Identifikasi siapa yang nilainya di bawah rata-rata. Jangan berikan saran materi, hanya diagnosa.";
        } elseif ($level === 'remedial') {
            $prompt = "Bertindaklah sebagai ahli kurikulum. Data: {$jsonData}. 
            1. Identifikasi siswa yang lemah per topik. 
            2. Analisis butir soal: Mengapa soal tertentu banyak yang salah? Analisis opsi pengecohnya. 
            3. Berikan saran materi spesifik yang harus dijelaskan ulang di kelas dan strategi remedial.";
        } elseif ($level === 'full_insight') {
            $prompt = "Bertindaklah sebagai konsultan pendidikan senior. Data: {$jsonData}. 
            Berikan analisis menyeluruh: Psikometrik soal, pola jawaban menebak (guessing pattern), rekomendasi kurikulum jangka panjang, dan personalisasi learning path untuk setiap siswa.";
        }

        if (empty($prompt)) {
            return "Upgrade paket Anda untuk melihat analisis AI.";
        }

        $response = $this->makeRequest($prompt, false);
        return is_string($response) ? $response : json_encode($response);
    }

    private function makeRequest(string $prompt, bool $expectJson = true)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}?key={$this->apiKey}", [
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 8192,
                ]
            ]);

            if ($response->failed()) {
                Log::error('Gemini API Error: ' . $response->body());
                return $expectJson ? [] : 'Error generating content.';
            }

            $responseData = $response->json();
            $text = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            if ($expectJson) {
                $jsonString = str_replace(['```json', '```'], '', $text);
                $result = json_decode($jsonString, true);
                return is_array($result) ? $result : [];
            }

            return $text;

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return $expectJson ? [] : 'Service unavailable.';
        }
    }
}