<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
    
    <style>
        /* 2. Override Tailwind Prose styles agar tidak konflik dengan Highlight.js */
        .prose pre {
            background-color: #282c34 !important; /* Warna background Atom One Dark */
            color: #abb2bf !important;
            padding: 0 !important;
            margin: 1em 0 !important;
            border-radius: 0.75rem !important;
            overflow-x: auto;
        }

        .prose pre code {
            background-color: transparent !important;
            color: inherit !important;
            font-family: 'Fira Code', ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
            padding: 1.25rem !important;
            border: none !important;
            display: block !important; /* Pastikan code block memanjang */
            font-size: 0.875rem !important;
            line-height: 1.7 !important;
        }

        /* Hilangkan backtick (`) default dari prose jika ada */
        .prose code::before,
        .prose code::after {
            content: "" !important;
            display: none !important;
        }
    </style>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-white leading-tight">{{ $quiz->title }}</h2>
                <p class="text-sm text-indigo-300 mt-1 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Waktu Pengerjaan: <span class="font-mono font-bold">{{ $quiz->timer }} Menit</span>
                </p>
            </div>
            <div class="bg-indigo-900/50 border border-indigo-500/30 px-4 py-2 rounded-lg text-indigo-200 text-sm font-mono" id="timer-display">
                Sisa Waktu: --:--
            </div>
        </div>
    </x-slot>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/javascript.min.js"></script>
    
    <script>
        window.MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']],
                displayMath: [['$$', '$$'], ['\\[', '\\]']]
            },
            svg: { fontCache: 'global' }
        };
    </script>
    <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 4. Inisialisasi Highlight.js
            hljs.highlightAll();

            let duration = {{ $quiz->timer }} * 60; 
            const display = document.querySelector('#timer-display');
            
            const timer = setInterval(function () {
                let minutes = parseInt(duration / 60, 10);
                let seconds = parseInt(duration % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = "Sisa Waktu: " + minutes + ":" + seconds;

                if (--duration < 0) {
                    clearInterval(timer);
                    Swal.fire({
                        title: 'Waktu Habis!',
                        text: 'Jawaban Anda akan dikumpulkan secara otomatis.',
                        icon: 'info',
                        background: '#1f2937',
                        color: '#fff',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        document.getElementById('quiz-form').submit();
                    });
                }
            }, 1000);
        });
    </script>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <form id="quiz-form" action="{{ route('quizzes.submit', [$quiz, $attempt]) }}" method="POST">
                @csrf
                
                <div class="space-y-8">
                    @foreach($quiz->questions as $index => $question)
                    <div class="bg-gray-800 shadow-xl sm:rounded-2xl p-6 border border-gray-700 relative group transition-all duration-300 hover:border-gray-600">
                        <div class="absolute -left-3 -top-3 bg-gradient-to-br from-indigo-600 to-purple-600 text-white w-10 h-10 flex items-center justify-center rounded-xl shadow-lg font-bold border border-white/10 z-10">
                            {{ $index + 1 }}
                        </div>

                        <div class="ml-4 mt-2">
                        <div class="text-lg font-medium text-white mb-6 leading-relaxed prose prose-invert max-w-none">
                            {!! $question->question_text !!}
                        </div>

                            @if($question->question_type === 'multiple_choice')
                                <div class="space-y-3">
                                    @foreach($question->options as $option)
                                    <label class="flex items-center p-4 rounded-xl border border-gray-700 bg-gray-900/30 cursor-pointer transition-all duration-200 hover:bg-indigo-900/20 hover:border-indigo-500/50 group-hover:bg-gray-750">
                                        <div class="relative flex items-center">
                                            <input type="radio" 
                                                   name="answers[{{ $question->id }}]" 
                                                   value="{{ $option->id }}" 
                                                   class="w-5 h-5 border-gray-600 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-gray-900 bg-gray-800 transition duration-150 ease-in-out"
                                                   required>
                                        </div>
                                        <span class="ml-4 text-gray-300 group-hover:text-white transition-colors select-none">
                                            {{ $option->option_text }}
                                        </span>
                                    </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="relative">
                                    <textarea name="answers[{{ $question->id }}]" 
                                              rows="4" 
                                              class="w-full bg-gray-900/50 border-gray-600 text-white rounded-xl focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-500 transition shadow-inner"
                                              placeholder="Tulis jawaban Anda di sini..." required></textarea>
                                    <div class="absolute bottom-3 right-3 text-xs text-gray-500 pointer-events-none">
                                        Essay
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-10 sticky bottom-6 z-20">
                    <div class="bg-gray-900/80 backdrop-blur-md p-4 rounded-2xl border border-gray-700 shadow-2xl flex justify-between items-center">
                        <div class="text-gray-400 text-sm hidden sm:block">
                            Pastikan semua soal telah terjawab.
                        </div>
                        
                        <button type="button" 
                                onclick="confirmAction(event, 'quiz-form', 'Selesai Mengerjakan?', 'Pastikan Anda sudah memeriksa semua jawaban sebelum mengumpulkan.', 'Ya, Kumpulkan!')"
                                class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl font-bold text-white text-lg tracking-wide hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition-all duration-200 shadow-lg transform hover:-translate-y-1">
                            <span>Selesai & Kumpulkan</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>