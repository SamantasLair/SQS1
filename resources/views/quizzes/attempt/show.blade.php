<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
    
    <style>
        .prose pre { background: #1e293b !important; border-radius: 0.75rem; padding: 1em; margin: 1em 0; }
        .prose code { color: #e2e8f0 !important; font-family: 'Fira Code', monospace; }
        .question-nav-btn { transition: all 0.2s; }
        .question-nav-btn:hover { transform: translateY(-2px); }
        .question-nav-btn.active { border-color: #6366f1; box-shadow: 0 0 15px rgba(99, 102, 241, 0.3); background: #312e81; color: white; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #1f2937; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #4b5563; border-radius: 10px; }
        input[type="radio"]:checked + div {
            background-color: rgba(79, 70, 229, 0.2); 
            border-color: #6366f1;
        }
        input[type="radio"]:checked + div .radio-indicator {
            background-color: #6366f1;
            border-color: #6366f1;
        }
        input[type="radio"]:checked + div .radio-dot {
            opacity: 1;
            transform: scale(1);
        }
    </style>

    <div class="min-h-screen bg-gray-900 pb-12">
        <div class="bg-gray-800 border-b border-gray-700 sticky top-0 z-50 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-white font-bold text-lg leading-tight">{{ Str::limit($quiz->title, 40) }}</h1>
                            <p class="text-gray-400 text-xs">Sedang Mengerjakan</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-gray-900 rounded-lg border border-gray-700">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span id="timer-display" class="font-mono text-xl font-bold text-white tracking-widest">00:00</span>
                        </div>
                        <button type="submit" form="quiz-form" onclick="return confirm('Yakin ingin mengumpulkan jawaban?')" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-2 rounded-lg font-bold transition shadow-lg shadow-indigo-900/50 text-sm">
                            Selesai
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="w-full bg-gray-700 h-1">
                <div class="bg-indigo-500 h-1 transition-all duration-1000 ease-linear" id="progress-bar" style="width: 100%"></div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="lg:w-3/4">
                    <form action="{{ route('quizzes.submit', [$quiz, $attempt]) }}" method="POST" id="quiz-form">
                        @csrf
                        <div class="space-y-12">
                            @foreach($quiz->questions as $index => $question)
                                <div id="question-{{ $index + 1 }}" class="scroll-mt-32">
                                    <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 md:p-8 shadow-xl relative overflow-hidden group hover:border-gray-600 transition-all">
                                        <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-600"></div>
                                        
                                        <div class="flex gap-4 mb-6">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-700 text-gray-300 flex items-center justify-center font-bold border border-gray-600">
                                                {{ $index + 1 }}
                                            </div>
                                            <div class="flex-grow prose prose-invert max-w-none text-lg text-gray-200">
                                                {!! $question->question_text !!}
                                            </div>
                                        </div>

                                        @if($question->question_type === 'multiple_choice')
                                            <div class="grid grid-cols-1 gap-3 pl-12">
                                                @foreach($question->options as $option)
                                                    <label class="relative cursor-pointer group">
                                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="peer sr-only" onchange="markAnswered({{ $index + 1 }})">
                                                        
                                                        <div class="p-4 rounded-xl bg-gray-900/50 border border-gray-700 transition-all hover:bg-gray-700/50 flex items-center gap-4 group-hover:border-gray-600">
                                                            {{-- Custom Radio Indicator --}}
                                                            <div class="radio-indicator w-6 h-6 rounded-full border-2 border-gray-500 flex items-center justify-center transition-all bg-gray-800 flex-shrink-0">
                                                                <div class="radio-dot w-3 h-3 rounded-full bg-white opacity-0 transform scale-0 transition-all duration-200"></div>
                                                            </div>
                                                            
                                                            <span class="text-gray-300 font-medium text-base select-none">{!! $option->option_text !!}</span>
                                                        </div>
                                                    </label>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="pl-12">
                                                <textarea name="answers[{{ $question->id }}]" rows="4" class="w-full bg-gray-900 border-gray-700 rounded-xl text-white p-4 focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all placeholder-gray-600" placeholder="Ketik jawaban Anda di sini..." oninput="markAnswered({{ $index + 1 }})"></textarea>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>

                <div class="lg:w-1/4">
                    <div class="sticky top-24">
                        <div class="bg-gray-800 rounded-2xl border border-gray-700 shadow-xl overflow-hidden">
                            <div class="p-4 border-b border-gray-700 bg-gray-800/50 backdrop-blur-sm">
                                <h3 class="text-white font-bold flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                    Navigasi Soal
                                </h3>
                            </div>
                            <div class="p-4">
                                <div class="grid grid-cols-5 gap-2 max-h-[60vh] overflow-y-auto custom-scrollbar pr-1">
                                    @foreach($quiz->questions as $index => $question)
                                        <a href="#question-{{ $index + 1 }}" id="nav-btn-{{ $index + 1 }}" class="question-nav-btn aspect-square flex items-center justify-center rounded-lg bg-gray-900 border border-gray-700 text-gray-400 font-medium text-sm hover:text-white hover:bg-gray-700 transition-all">
                                            {{ $index + 1 }}
                                        </a>
                                    @endforeach
                                </div>
                                <div class="mt-6 pt-4 border-t border-gray-700">
                                    <div class="flex items-center gap-4 text-xs text-gray-400 mb-4">
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-3 h-3 rounded bg-gray-900 border border-gray-700"></div> Belum
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <div class="w-3 h-3 rounded bg-indigo-600 border border-indigo-500"></div> Dijawab
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>

    <script>
        function markAnswered(index) {
            const btn = document.getElementById(`nav-btn-${index}`);
            btn.classList.add('bg-indigo-600', 'border-indigo-500', 'text-white');
            btn.classList.remove('bg-gray-900', 'border-gray-700', 'text-gray-400');
        }

        document.addEventListener('DOMContentLoaded', function() {
            let totalSeconds = {{ ($quiz->timer ?? 30) * 60 }};
            const display = document.getElementById('timer-display');
            const progressBar = document.getElementById('progress-bar');
            const initialSeconds = totalSeconds;

            const timer = setInterval(() => {
                totalSeconds--;
                
                const hours = Math.floor(totalSeconds / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;

                let timeString = '';
                if (hours > 0) timeString += `${hours.toString().padStart(2, '0')}:`;
                timeString += `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                display.textContent = timeString;

                const percent = (totalSeconds / initialSeconds) * 100;
                progressBar.style.width = `${percent}%`;

                if (percent < 20) {
                    progressBar.classList.remove('bg-indigo-500');
                    progressBar.classList.add('bg-red-500');
                    display.classList.add('text-red-400', 'animate-pulse');
                }

                if (totalSeconds <= 0) {
                    clearInterval(timer);
                    document.getElementById('quiz-form').submit();
                }
            }, 1000);
        });
    </script>
</x-app-layout>