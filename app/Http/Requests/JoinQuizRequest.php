<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JoinQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'size:6', 'exists:quizzes,join_code'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Silakan masukkan kode kuis.',
            'code.size' => 'Kode kuis harus terdiri dari 6 karakter.',
            'code.exists' => 'Kode kuis tidak ditemukan. Silakan periksa kembali.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'code' => strtoupper($this->input('code')),
        ]);
    }
}