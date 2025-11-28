<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.question_type' => 'required|in:multiple_choice,essay',
            'questions.*.image' => 'nullable|image|max:2048',
            'questions.*.options' => 'required_if:questions.*.question_type,multiple_choice|array',
            'questions.*.options.*.option_text' => 'required_with:questions.*.options|string',
            'questions.*.correct_option_index' => 'required_if:questions.*.question_type,multiple_choice',
        ];
    }

    public function messages(): array
    {
        return [
            'questions.required' => 'Minimal harus ada satu pertanyaan.',
            'questions.*.question_text.required' => 'Teks pertanyaan wajib diisi.',
            'questions.*.correct_option_index.required_if' => 'Pilih kunci jawaban untuk soal pilihan ganda.',
        ];
    }
}