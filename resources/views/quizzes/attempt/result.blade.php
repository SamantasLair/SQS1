<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            {{ __('Hasil Kuis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 p-8 text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-purple-500 to-pink-500"></div>
                
                <h3 class="text-gray-400 uppercase tracking-widest text-sm font-bold mb-2">Skor Akhir Anda</h3>
                <div class="text-6xl font-black text-white mb-4">
                    {{ number_format($score, 0) }}
                    <span class="text-2xl text-gray-500 font-medium">/ 100</span>
                </div>

                <div class="flex justify-center gap-8 mb-8">
                    <div class="text-center">
                        <div class="text-green-400 font-bold text-xl">{{ $correctAnswers }}</div>
                        <div class="text-gray-500 text-xs uppercase">Benar</div>
                    </div>
                    <div class="text-center">
                        <div class="text-red-400 font-bold text-xl">{{ $totalQuestions - $correctAnswers }}</div>
                        <div class="text-gray-500 text-xs uppercase">Salah</div>
                    </div>
                </div>

                <div class="flex justify-center gap-4">
                    <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition">
                        Ke Dashboard
                    </a>
                    <a href="{{ route('quizzes.leaderboard', $attempt->quiz) }}" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg transition shadow-lg shadow-indigo-600/20">
                        Lihat Leaderboard
                    </a>
                </div>
            </div>

            <div class="space-y-6">
                <h3 class="text-xl font-bold text-white px-2">Review Jawaban</h3>
                
                @foreach($questions as $index => $question)
                    @php
                        $userAnswer = $question->userAnswers->first();
                        $selectedOptionId = $userAnswer ? $userAnswer->option_id : null;
                        $isCorrect = $userAnswer && $userAnswer->option->is_correct;
                    @endphp

                    <div class="bg-gray-800 rounded-xl border {{ $isCorrect ? 'border-green-500/30' : 'border-red-500/30' }} p-6">
                        <div class="flex gap-4">
                            <span class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center font-bold {{ $isCorrect ? 'bg-green-900/50 text-green-400' : 'bg-red-900/50 text-red-400' }}">
                                {{ $index + 1 }}
                            </span>
                            <div class="w-full">
                                <p class="text-white text-lg font-medium mb-4">{!! nl2br(e($question->question_text)) !!}</p>
                                
                                <div class="grid grid-cols-1 gap-3">
                                    @foreach($question->options as $option)
                                        @php
                                            $isSelected = $selectedOptionId == $option->id;
                                            $isKey = $option->is_correct;
                                            
                                            $class = 'border-gray-700 bg-gray-900/30 text-gray-400';
                                            $icon = '';

                                            if ($isKey) {
                                                $class = 'border-green-500 bg-green-900/20 text-green-300';
                                                $icon = '<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                                            } elseif ($isSelected && !$isKey) {
                                                $class = 'border-red-500 bg-red-900/20 text-red-300';
                                                $icon = '<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                                            }
                                        @endphp

                                        <div class="flex items-center justify-between p-3 rounded-lg border {{ $class }}">
                                            <span class="flex-1">{{ $option->option_text }}</span>
                                            {!! $icon !!}
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="mt-3 text-xs text-gray-500 font-mono uppercase">
                                    Topik: {{ $question->topic ?? 'Umum' }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>