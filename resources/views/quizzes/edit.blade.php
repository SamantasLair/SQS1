<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-500/10 rounded-xl border border-indigo-500/20 shadow-inner">
                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">Edit Kuis</h2>
                    <div class="flex items-center gap-2 text-sm text-gray-400 mt-1">
                        <span class="text-indigo-400">Mode Editor Lengkap</span>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('quizzes.show', $quiz) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg font-medium text-xs text-gray-300 uppercase tracking-widest hover:bg-gray-700 hover:text-white transition ease-in-out duration-150">
                Batal & Kembali
            </a>
        </div>
    </x-slot>

    <style>
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; }
        .math-preview { min-height: 1.5rem; }

        /* Override Tailwind Prose styles untuk Highlight.js */
        .prose pre {
            background-color: #282c34 !important;
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
            display: block !important;
            font-size: 0.875rem !important;
            line-height: 1.7 !important;
        }

        .prose code::before,
        .prose code::after {
            content: "" !important;
            display: none !important;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/java.min.js"></script>

    <script>
        window.MathJax = {
            tex: { inlineMath: [['$', '$'], ['\\(', '\\)']] },
            svg: { fontCache: 'global' },
            startup: {
                ready: () => {
                    MathJax.startup.defaultReady();
                    // Fungsi render gabungan: MathJax + Highlight.js
                    window.updatePreview = (elemId, text) => {
                        const output = document.getElementById(elemId);
                        output.innerHTML = text;
                        
                        // Render Math
                        MathJax.typesetPromise([output]).catch((err) => console.log(err));
                        
                        // Render Code Highlighting
                        output.querySelectorAll('pre code').forEach((block) => {
                            hljs.highlightElement(block);
                        });
                    };
                }
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            hljs.highlightAll();
        });

        // Fungsi Salin Kode dengan Toast SweetAlert
        function copyCode(code) {
            navigator.clipboard.writeText(code).then(() => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: false,
                    background: '#1f2937',
                    color: '#fff',
                    iconColor: '#4ade80'
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Kode berhasil disalin!'
                });
            });
        }
    </script>
    <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('quizzes.update', $quiz) }}" method="POST" id="main-quiz-form">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-gray-800 shadow-xl sm:rounded-xl p-6 border border-gray-700 sticky top-6">
                            <h3 class="text-lg font-bold text-white mb-4 border-b border-gray-700 pb-2">Pengaturan Dasar</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Judul Kuis</label>
                                    <input type="text" name="title" value="{{ old('title', $quiz->title) }}" class="block w-full rounded-lg bg-gray-900 border-gray-600 text-white focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-500 py-2 px-3 shadow-sm" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Deskripsi</label>
                                    <textarea name="description" rows="3" class="block w-full rounded-lg bg-gray-900 border-gray-600 text-white focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-500 py-2 px-3 shadow-sm">{{ old('description', $quiz->description) }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Durasi (Menit)</label>
                                    <div class="relative">
                                        <input type="number" name="timer" value="{{ old('timer', $quiz->timer) }}" class="block w-full rounded-lg bg-gray-900 border-gray-600 text-white focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-500 py-2 px-3 shadow-sm font-mono" required min="1">
                                        <span class="absolute right-3 top-2 text-gray-500 text-sm">mnt</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-700">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kode Join (Klik untuk Salin)</label>
                                <div onclick="copyCode('{{ $quiz->join_code }}')" class="cursor-pointer group relative bg-gray-900 border border-gray-600 rounded-lg p-3 text-center hover:border-indigo-500 transition-colors">
                                    <div class="text-2xl font-mono font-bold text-blue-400 group-hover:text-blue-300">{{ $quiz->join_code }}</div>
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-gray-900/90 rounded-lg transition-opacity">
                                        <span class="text-sm text-white font-bold flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                            Salin
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:scale-[1.02]">
                                    Simpan Semua Perubahan
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-white">Daftar Soal ({{ $quiz->questions->count() }})</h3>
                            <div class="text-xs text-gray-400 bg-gray-900/50 px-3 py-1.5 rounded-lg border border-gray-700/50 flex items-center gap-2">
                                <span class="flex items-center gap-1">
                                    <strong class="text-indigo-400">Info:</strong>
                                    Gunakan <code>$ $</code> untuk rumus & <code>&lt;pre&gt;&lt;code&gt; &lt;/code&gt;&lt;pre&gt;</code> untuk kode.
                                </span>
                            </div>
                        </div>

                        @forelse($quiz->questions as $i => $question)
                        <div class="bg-gray-800 shadow-lg rounded-xl p-5 border border-gray-700 relative group">
                            <input type="hidden" name="questions[{{ $i }}][id]" value="{{ $question->id }}">
                            <input type="hidden" name="questions[{{ $i }}][question_type]" value="{{ $question->question_type }}">

                            <div class="flex justify-between items-start mb-4">
                                <div class="bg-indigo-900/50 text-indigo-300 font-bold w-8 h-8 flex items-center justify-center rounded-lg border border-indigo-500/30 shrink-0">
                                    {{ $i + 1 }}
                                </div>
                                
                                <button type="button" 
                                        onclick="confirmAction(event, 'delete-question-{{ $question->id }}', 'Hapus Soal Ini?', 'Soal yang dihapus tidak bisa dikembalikan.')" 
                                        class="text-gray-500 hover:text-red-400 p-1 transition-colors" 
                                        title="Hapus Soal Ini">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Teks Soal</label>
                                    <textarea 
                                        name="questions[{{ $i }}][text]" 
                                        rows="3" 
                                        class="block w-full rounded-lg bg-gray-900 border-gray-600 text-white text-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-600"
                                        oninput="window.updatePreview('preview-q-{{ $i }}', this.value)"
                                    >{{ $question->question_text }}</textarea>
                                </div>
                                <div class="bg-gray-900/50 rounded-lg p-3 border border-gray-700/50 flex flex-col justify-center">
                                    <label class="block text-[10px] font-bold text-indigo-400 uppercase mb-1">Preview:</label>
                                    <div id="preview-q-{{ $i }}" class="text-gray-200 text-sm math-preview prose prose-invert max-w-none">
                                        {!! $question->question_text !!}
                                    </div>
                                </div>
                            </div>

                            @if($question->question_type === 'multiple_choice')
                                <div class="space-y-3 bg-gray-900/30 p-4 rounded-lg border border-gray-700/50">
                                    <p class="text-xs text-gray-400 font-bold uppercase mb-2">Pilihan Jawaban</p>
                                    
                                    @foreach($question->options as $j => $option)
                                    <div class="flex items-center gap-3">
                                        <input type="hidden" name="questions[{{ $i }}][options][{{ $j }}][id]" value="{{ $option->id }}">
                                        
                                        <input type="radio" 
                                               name="questions[{{ $i }}][correct_option]" 
                                               value="{{ $j }}" 
                                               {{ $option->is_correct ? 'checked' : '' }}
                                               class="w-4 h-4 text-green-500 bg-gray-800 border-gray-600 focus:ring-green-500 cursor-pointer">
                                        
                                        <div class="grow">
                                            <input type="text" 
                                                   name="questions[{{ $i }}][options][{{ $j }}][text]" 
                                                   value="{{ $option->option_text }}" 
                                                   class="block w-full rounded-md bg-gray-800 border-gray-600 text-gray-300 text-xs focus:border-green-500 focus:ring-green-500 h-8 px-2">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-yellow-900/10 p-3 rounded border border-yellow-600/20 text-yellow-500 text-xs flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Soal Essay
                                </div>
                            @endif

                        </div>
                        @empty
                        <div class="text-center py-12 bg-gray-800 border border-gray-700 border-dashed rounded-xl">
                            <p class="text-gray-500">Belum ada soal.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </form>

            @foreach($quiz->questions as $question)
                <form id="delete-question-{{ $question->id }}" action="{{ route('questions.destroy', $question->id) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach

        </div>
    </div>
</x-app-layout>