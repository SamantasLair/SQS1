<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
    
    <style>
        .prose pre { margin: 0.5em 0 !important; padding: 0 !important; background: #282c34 !important; border-radius: 0.5rem; }
        .prose pre code { padding: 1em !important; background: transparent !important; color: #abb2bf !important; }
        .math-display { overflow-x: auto; }
    </style>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-white tracking-tight drop-shadow-md">
                {{ __('Detail Kuis') }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('quizzes.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-600 text-gray-300 font-bold hover:bg-gray-800 hover:text-white transition-all">
                    Kembali
                </a>
                <a href="{{ route('quizzes.edit', $quiz) }}" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-indigo-600/20 transition-all">
                    Edit Kuis
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-gray-900 rounded-3xl border border-gray-800 shadow-2xl overflow-hidden relative">
                <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-600/10 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
                <div class="p-8 relative z-10">
                    <div class="flex flex-col md:flex-row gap-6 justify-between items-start">
                        <div>
                            <h1 class="text-3xl font-black text-white mb-2">{{ $quiz->title }}</h1>
                            <p class="text-gray-400 text-lg leading-relaxed">{{ $quiz->description ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                        <div class="flex flex-col gap-3 min-w-[200px]">
                            <div class="bg-gray-800/50 p-4 rounded-2xl border border-gray-700">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Kode Join</span>
                                <div class="flex items-center justify-between">
                                    <span class="text-2xl font-mono font-bold text-indigo-400 tracking-widest">{{ $quiz->join_code }}</span>
                                    <button onclick="navigator.clipboard.writeText('{{ $quiz->join_code }}'); alert('Kode disalin!');" class="text-gray-500 hover:text-white transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="flex-1 bg-gray-800/50 p-3 rounded-2xl border border-gray-700 text-center">
                                    <span class="block text-xs font-bold text-gray-500 uppercase">Durasi</span>
                                    <span class="text-white font-bold">{{ $quiz->timer }}m</span>
                                </div>
                                <div class="flex-1 bg-gray-800/50 p-3 rounded-2xl border border-gray-700 text-center">
                                    <span class="block text-xs font-bold text-gray-500 uppercase">Soal</span>
                                    <span class="text-white font-bold">{{ $quiz->questions->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-800 flex gap-4">
                        <a href="{{ route('quizzes.analyze', $quiz) }}" class="flex items-center gap-2 px-5 py-2.5 bg-gray-800 hover:bg-gray-700 text-indigo-400 font-bold rounded-xl transition border border-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            Analisis AI
                        </a>
                        <a href="{{ route('quizzes.leaderboard', $quiz) }}" class="flex items-center gap-2 px-5 py-2.5 bg-gray-800 hover:bg-gray-700 text-yellow-500 font-bold rounded-xl transition border border-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Leaderboard
                        </a>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div class="flex justify-between items-center px-2">
                    <h3 class="text-xl font-bold text-white">Daftar Pertanyaan</h3>
                    <span class="text-xs text-gray-500 bg-gray-900 px-3 py-1 rounded-full border border-gray-800">
                        Total: {{ $quiz->questions->count() }}
                    </span>
                </div>
                
                @forelse($quiz->questions as $index => $question)
                    <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6 shadow-lg">
                        <div class="flex gap-4">
                            <span class="flex-shrink-0 w-10 h-10 bg-gray-800 rounded-xl flex items-center justify-center text-indigo-400 font-black text-lg shadow-inner">
                                {{ $index + 1 }}
                            </span>
                            
                            <div class="flex-1 min-w-0"> <div class="text-white text-lg font-medium leading-relaxed mb-6 prose prose-invert max-w-none">
                                    {!! $question->question_text !!}
                                </div>

                                @if($question->question_type === 'multiple_choice')
                                    <div class="grid grid-cols-1 gap-3">
                                        @foreach($question->options as $option)
                                            <div class="flex items-start gap-4 p-4 rounded-xl border {{ $option->is_correct ? 'bg-green-500/10 border-green-500/30' : 'bg-gray-800/50 border-gray-700' }}">
                                                <div class="flex-shrink-0 w-6 h-6 rounded-full border-2 flex items-center justify-center mt-0.5 {{ $option->is_correct ? 'border-green-500 bg-green-500' : 'border-gray-600' }}">
                                                    @if($option->is_correct)
                                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    @endif
                                                </div>
                                                
                                                <div class="flex-1 min-w-0 text-gray-300 prose prose-invert prose-sm max-w-none">
                                                    {!! $option->option_text !!}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-4 bg-gray-800/50 rounded-xl border border-gray-700 text-gray-400 italic flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Soal Essay / Uraian
                                    </div>
                                @endif

                                <div class="mt-4 pt-4 border-t border-gray-800 flex justify-between items-center">
                                    <span class="px-3 py-1 bg-gray-800 rounded-lg text-xs font-bold text-gray-500 uppercase tracking-wider border border-gray-700">
                                        {{ $question->topic ?? 'Umum' }}
                                    </span>
                                    <form action="{{ route('questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 text-xs font-bold transition flex items-center gap-1 uppercase tracking-wider">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-gray-900 rounded-3xl border border-gray-800 border-dashed">
                        <div class="p-4 bg-gray-800 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4 border border-gray-700">
                            <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-white font-bold text-xl mb-2">Belum ada soal</h3>
                        <p class="text-gray-500 mb-8">Kuis ini masih kosong. Silakan tambahkan soal manual atau gunakan AI.</p>
                        <a href="{{ route('quizzes.edit', $quiz) }}" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold rounded-xl transition shadow-lg shadow-indigo-600/20">
                            Tambah Soal
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/java.min.js"></script>
    
    <script>
        // Inisialisasi Highlight.js
        document.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('pre code').forEach((block) => {
                hljs.highlightElement(block);
            });
        });

        // Konfigurasi MathJax
        window.MathJax = {
            tex: { inlineMath: [['$', '$'], ['\\(', '\\)']] },
            svg: { fontCache: 'global' },
            startup: {
                pageReady: () => {
                    return MathJax.startup.defaultPageReady().then(() => {
                        console.log('MathJax initial rendering complete');
                    });
                }
            }
        };
    </script>
    <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>
</x-app-layout>