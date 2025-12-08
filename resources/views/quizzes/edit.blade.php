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

        .dark-input {
            background-color: #111827;
            border-color: #4b5563;
            color: white;
        }
        .dark-input:focus {
            border-color: #6366f1;
            --tw-ring-color: #6366f1;
        }

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
        .prose code::before, .prose code::after { display: none !important; }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/java.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/sql.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.MathJax = {
            tex: { inlineMath: [['$', '$'], ['\\(', '\\)']] },
            svg: { fontCache: 'global' },
            startup: {
                ready: () => {
                    MathJax.startup.defaultReady();
                    window.updatePreview = (elemId, text) => {
                        const output = document.getElementById(elemId);
                        if(output) {
                            output.innerHTML = text;
                            MathJax.typesetPromise([output]).catch((err) => console.log(err));
                            output.querySelectorAll('pre code').forEach((block) => {
                                hljs.highlightElement(block);
                            });
                        }
                    };
                }
            }
        };

        document.addEventListener('DOMContentLoaded', function() {
            hljs.highlightAll();
        });

        function copyCode(code) {
            navigator.clipboard.writeText(code).then(() => {
                const Toast = Swal.mixin({
                    toast: true, position: 'top-end', showConfirmButton: false,
                    timer: 2000, background: '#1f2937', color: '#fff', iconColor: '#4ade80'
                });
                Toast.fire({ icon: 'success', title: 'Kode disalin!' });
            });
        }
    </script>
    <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>

    <form id="form-update" action="{{ route('quizzes.update', $quiz) }}" method="POST" style="display: none;">
        @csrf
        @method('PUT')
    </form>

    <form id="form-ai" action="{{ route('quizzes.add_ai', $quiz) }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="ai_topic" id="real_ai_topic">
        <input type="hidden" name="ai_q_type" id="real_ai_type">
        <input type="hidden" name="ai_q_count" id="real_ai_count">
    </form>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-900/50 border-l-4 border-green-500 text-green-200 rounded-r shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-900/50 border-l-4 border-red-500 text-red-200 rounded-r shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-1 space-y-6">
                    
                    <div class="bg-gray-800 shadow-xl sm:rounded-xl p-6 border border-gray-700">
                        <h3 class="text-lg font-bold text-white mb-4 border-b border-gray-700 pb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Tools Editor
                        </h3>

                        <div class="space-y-4 mb-6">
                            <label class="block text-xs font-bold text-gray-500 uppercase">Tambah Manual</label>
                            <div class="grid grid-cols-2 gap-2">
                                <select id="manual-type" class="dark-input block w-full rounded-lg py-2 px-3 text-sm">
                                    <option value="multiple_choice">Pilgan</option>
                                    <option value="essay">Essay</option>
                                </select>
                                <input type="number" id="manual-count" value="1" min="1" max="10" class="dark-input block w-full rounded-lg py-2 px-3 text-sm text-center">
                            </div>
                            <button type="button" onclick="addQuestions()" class="w-full py-2 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition text-sm font-bold border border-gray-600">
                                + Tambahkan Soal
                            </button>
                        </div>

                        <div class="space-y-4 pt-4 border-t border-gray-700">
                            <div class="flex justify-between items-center">
                                <label class="block text-xs font-bold text-gray-500 uppercase flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    Generate AI
                                </label>
                                @if(Auth::user()->is_premium)
                                    <span class="text-[10px] bg-purple-900/50 text-purple-300 px-2 py-0.5 rounded border border-purple-500/30">UNLIMITED</span>
                                @else
                                    <span class="text-[10px] {{ Auth::user()->ai_usage_count >= Auth::user()->getAiDailyLimit() ? 'text-red-400' : 'text-gray-400' }}">
                                        Sisa: {{ Auth::user()->getAiDailyLimit() - Auth::user()->ai_usage_count }}
                                    </span>
                                @endif
                            </div>
                            
                            <textarea id="ui_ai_topic" rows="2" class="dark-input block w-full rounded-lg py-2 px-3 text-sm" placeholder="Topik tambahan..."></textarea>
                            
                            <div class="grid grid-cols-2 gap-2">
                                <select id="ui_ai_type" class="dark-input block w-full rounded-lg py-2 px-3 text-sm">
                                    <option value="multiple_choice">Pilgan</option>
                                    <option value="essay">Essay</option>
                                </select>
                                <select id="ui_ai_count" class="dark-input block w-full rounded-lg py-2 px-3 text-sm text-center">
                                    <option value="5">5 Soal</option>
                                    <option value="10">10 Soal</option>
                                    <option value="15">15 Soal</option>
                                    <option value="20">20 Soal</option>
                                </select>
                            </div>
                            
                            <button type="button" onclick="triggerAiSubmit()" class="w-full py-2 bg-purple-600 hover:bg-purple-500 text-white rounded-lg transition text-sm font-bold shadow-lg shadow-purple-900/30 disabled:opacity-50 disabled:cursor-not-allowed" 
                                {{ (!Auth::user()->is_premium && Auth::user()->ai_usage_count >= Auth::user()->getAiDailyLimit()) ? 'disabled' : '' }}>
                                ✨ Generate via AI
                            </button>
                        </div>
                    </div>

                    <div class="bg-gray-800 shadow-xl sm:rounded-xl p-6 border border-gray-700 sticky top-6">
                        <h3 class="text-lg font-bold text-white mb-4 border-b border-gray-700 pb-2">Pengaturan Dasar</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Judul Kuis</label>
                                <input type="text" name="title" form="form-update" value="{{ old('title', $quiz->title) }}" class="dark-input block w-full rounded-lg py-2 px-3 shadow-sm" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Deskripsi</label>
                                <textarea name="description" form="form-update" rows="3" class="dark-input block w-full rounded-lg py-2 px-3 shadow-sm">{{ old('description', $quiz->description) }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-1">Durasi (Menit)</label>
                                <div class="relative">
                                    <input type="number" name="timer" form="form-update" value="{{ old('timer', $quiz->timer) }}" class="dark-input block w-full rounded-lg py-2 px-3 shadow-sm font-mono" required min="1">
                                    <span class="absolute right-3 top-2 text-gray-500 text-sm">mnt</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-gray-700">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kode Join</label>
                            <div onclick="copyCode('{{ $quiz->join_code }}')" class="cursor-pointer group relative bg-gray-900 border border-gray-600 rounded-lg p-3 text-center hover:border-indigo-500 transition-colors">
                                <div class="text-2xl font-mono font-bold text-blue-400 group-hover:text-blue-300">{{ $quiz->join_code }}</div>
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-gray-900/90 rounded-lg transition-opacity">
                                    <span class="text-sm text-white font-bold flex items-center gap-1">Salin</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" form="form-update" class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 transition-all transform hover:scale-[1.02]">
                                Simpan Semua Perubahan
                            </button>
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold text-white">Daftar Soal</h3>
                        <div class="text-xs text-gray-400 bg-gray-900/50 px-3 py-1.5 rounded-lg border border-gray-700/50 flex items-center gap-2">
                            <span>Info: Gunakan <code>$ $</code> untuk rumus</span>
                        </div>
                    </div>

                    <div id="questions-container" class="space-y-6">
                        @forelse($quiz->questions as $i => $question)
                        <div class="bg-gray-800 shadow-lg rounded-xl p-5 border border-gray-700 relative group question-item">
                            <input type="hidden" form="form-update" name="questions[{{ $i }}][id]" value="{{ $question->id }}">
                            <input type="hidden" form="form-update" name="questions[{{ $i }}][type]" value="{{ $question->question_type }}">

                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-2">
                                    <div class="bg-indigo-900/50 text-indigo-300 font-bold w-8 h-8 flex items-center justify-center rounded-lg border border-indigo-500/30 shrink-0 number-badge">
                                        {{ $i + 1 }}
                                    </div>
                                    <span class="text-xs px-2 py-0.5 rounded font-bold uppercase {{ $question->question_type == 'essay' ? 'bg-yellow-900/30 text-yellow-500 border border-yellow-500/30' : 'bg-blue-900/30 text-blue-400 border border-blue-500/30' }}">
                                        {{ $question->question_type == 'multiple_choice' ? 'PILGAN' : 'ESSAY' }}
                                    </span>
                                </div>
                                
                                <button type="button" onclick="removeQuestion(this)" class="text-gray-500 hover:text-red-400 p-1 transition-colors" title="Hapus Soal">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Teks Soal</label>
                                    <textarea name="questions[{{ $i }}][text]" form="form-update" rows="3" 
                                        class="dark-input block w-full rounded-lg py-2 px-3 text-sm placeholder-gray-600"
                                        oninput="window.updatePreview('preview-q-{{ $i }}', this.value)"
                                        required>{{ $question->question_text }}</textarea>
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
                                        <input type="hidden" form="form-update" name="questions[{{ $i }}][options][{{ $j }}][id]" value="{{ $option->id }}">
                                        <input type="radio" form="form-update" name="questions[{{ $i }}][correct]" value="{{ $j }}" {{ $option->is_correct ? 'checked' : '' }} class="w-4 h-4 text-green-500 bg-gray-800 border-gray-600 focus:ring-green-500 cursor-pointer">
                                        <div class="grow">
                                            <input type="text" form="form-update" name="questions[{{ $i }}][options][{{ $j }}][text]" value="{{ $option->option_text }}" class="block w-full rounded-md bg-gray-800 border-gray-600 text-gray-300 text-xs focus:border-green-500 focus:ring-green-500 h-8 px-2" required>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="space-y-2 bg-yellow-900/10 p-4 rounded-lg border border-yellow-600/20">
                                    <label class="block text-xs font-bold text-yellow-500 uppercase">Kunci Jawaban / Poin Penting</label>
                                    <textarea name="questions[{{ $i }}][essay_answer]" form="form-update" rows="3" class="dark-input block w-full rounded-md bg-gray-800 border-gray-600 text-gray-300 text-sm focus:border-yellow-500 focus:ring-yellow-500 placeholder-gray-600" placeholder="Masukkan jawaban referensi disini...">{{ $question->options->where('is_correct', true)->first()?->option_text ?? '' }}</textarea>
                                </div>
                            @endif
                        </div>
                        @empty
                        <div id="empty-state" class="text-center py-12 bg-gray-800 border border-gray-700 border-dashed rounded-xl">
                            <p class="text-gray-500">Belum ada soal. Tambahkan manual atau gunakan AI.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let uniqueIndexCounter = {{ $quiz->questions->count() }}; 
        
        function updateQuestionNumbers() {
            const items = document.querySelectorAll('.question-item');
            items.forEach((item, index) => {
                const badge = item.querySelector('.number-badge');
                if(badge) badge.textContent = index + 1;
            });
            const container = document.getElementById('questions-container');
            const emptyState = document.getElementById('empty-state');
            if (items.length === 0 && !emptyState) {
                container.innerHTML = `
                    <div id="empty-state" class="text-center py-12 bg-gray-800 border border-gray-700 border-dashed rounded-xl">
                        <p class="text-gray-500">Belum ada soal. Tambahkan manual atau gunakan AI.</p>
                    </div>`;
            } else if (items.length > 0 && emptyState) {
                emptyState.remove();
            }
        }

        function triggerAiSubmit() {
            const topic = document.getElementById('ui_ai_topic').value;
            const type = document.getElementById('ui_ai_type').value;
            const count = document.getElementById('ui_ai_count').value;

            if(!topic) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Kurang',
                    text: 'Mohon isi topik materi terlebih dahulu!',
                    background: '#1f2937', color: '#fff', iconColor: '#fbbf24'
                });
                return;
            }

            document.getElementById('real_ai_topic').value = topic;
            document.getElementById('real_ai_type').value = type;
            document.getElementById('real_ai_count').value = count;

            Swal.fire({
                title: 'Sedang Generate...',
                text: 'AI sedang menyusun soal, mohon tunggu.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); },
                background: '#1f2937', color: '#fff'
            });

            document.getElementById('form-ai').submit();
        }

        function addQuestions() {
            const type = document.getElementById('manual-type').value;
            const count = parseInt(document.getElementById('manual-count').value);
            const container = document.getElementById('questions-container');
            const emptyState = document.getElementById('empty-state');

            if(emptyState) emptyState.remove();

            for (let i = 0; i < count; i++) {
                uniqueIndexCounter++;
                const idx = 'new_' + uniqueIndexCounter + '_' + Math.floor(Math.random() * 1000); 
                let innerContent = '';

                if (type === 'multiple_choice') {
                    innerContent = `
                        <div class="space-y-3 bg-gray-900/30 p-4 rounded-lg border border-gray-700/50">
                            <p class="text-xs text-gray-400 font-bold uppercase mb-2">Pilihan Jawaban</p>
                            ${[0, 1, 2, 3].map(optI => `
                                <div class="flex items-center gap-3">
                                    <input type="radio" form="form-update" name="questions[${idx}][correct]" value="${optI}" ${optI===0 ? 'checked' : ''} class="w-4 h-4 text-green-500 bg-gray-800 border-gray-600 focus:ring-green-500 cursor-pointer">
                                    <div class="grow">
                                        <input type="text" form="form-update" name="questions[${idx}][options][${optI}][text]" placeholder="Opsi ${String.fromCharCode(65+optI)}" class="block w-full rounded-md bg-gray-800 border-gray-600 text-gray-300 text-xs focus:border-green-500 focus:ring-green-500 h-8 px-2" required>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    `;
                } else {
                    innerContent = `
                        <div class="space-y-2 bg-yellow-900/10 p-4 rounded-lg border border-yellow-600/20">
                            <label class="block text-xs font-bold text-yellow-500 uppercase">Kunci Jawaban / Poin Penting</label>
                            <textarea name="questions[${idx}][essay_answer]" form="form-update" rows="3" class="dark-input block w-full rounded-md bg-gray-800 border-gray-600 text-gray-300 text-sm focus:border-yellow-500 focus:ring-yellow-500 placeholder-gray-600" placeholder="Masukkan jawaban referensi disini..."></textarea>
                        </div>
                    `;
                }

                const template = `
                    <div class="bg-gray-800 shadow-lg rounded-xl p-5 border border-gray-700 relative group question-item mt-6 animate-fade-in">
                        <input type="hidden" form="form-update" name="questions[${idx}][type]" value="${type}">
                        
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-2">
                                <div class="bg-green-900/50 text-green-300 font-bold w-8 h-8 flex items-center justify-center rounded-lg border border-green-500/30 shrink-0 number-badge">
                                    0
                                </div>
                                <span class="text-xs px-2 py-0.5 rounded font-bold uppercase ${type === 'essay' ? 'bg-yellow-900/30 text-yellow-500 border border-yellow-500/30' : 'bg-blue-900/30 text-blue-400 border border-blue-500/30'}">
                                    ${type === 'multiple_choice' ? 'PILGAN' : 'ESSAY'}
                                </span>
                            </div>
                            <button type="button" onclick="removeQuestion(this)" class="text-gray-500 hover:text-red-400 p-1 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Teks Soal</label>
                                <textarea name="questions[${idx}][text]" form="form-update" rows="3" class="dark-input block w-full rounded-lg py-2 px-3 text-sm placeholder-gray-600" required placeholder="Tulis pertanyaan..."></textarea>
                            </div>
                            <div class="bg-gray-900/50 rounded-lg p-3 border border-gray-700/50 flex items-center justify-center text-gray-500 text-xs italic">
                                Preview akan muncul setelah disimpan
                            </div>
                        </div>
                        ${innerContent}
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', template);
            }
            updateQuestionNumbers();
        }

        function removeQuestion(btn) {
            if(confirm('Hapus soal ini?')) {
                btn.closest('.question-item').remove();
                updateQuestionNumbers();
            }
        }
    </script>

    <style>
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in { animation: fadeIn 0.3s ease-out; }
    </style>
</x-app-layout>