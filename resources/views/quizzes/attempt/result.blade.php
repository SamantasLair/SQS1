<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Hasil Kuis: {{ $attempt->quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    
                    <h3 class="text-2xl font-semibold">Kuis Selesai!</h3>

                    <div class="mt-6">
                        <p class="text-lg">Skor Anda:</p>
                        <p class="text-6xl font-bold text-blue-600 my-2">{{ number_format($score, 0) }}</p>
                        <p class="text-gray-700">Anda menjawab <span class="font-bold">{{ $correctAnswers }}</span> dari <span class="font-bold">{{ $totalQuestions }}</span> pertanyaan dengan benar.</p>
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('quizzes.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 mr-3">
                            Kembali ke Kuis Saya
                        </a>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                            Kembali ke Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>