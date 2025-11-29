<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-500/10 rounded-xl border border-indigo-500/20 shadow-inner">
                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">{{ $quiz->title }}</h2>
                    <div class="flex items-center gap-2 text-sm text-gray-400 mt-1">
                        <span class="hover:text-gray-300 transition-colors">Dashboard</span>
                        <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <span class="text-indigo-400">Detail Kuis</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('quizzes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-gray-600 rounded-lg font-medium text-xs text-gray-300 uppercase tracking-widest hover:bg-gray-700 hover:text-white focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Kembali
                </a>
                <a href="{{ route('quizzes.edit', $quiz) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150 shadow-lg shadow-indigo-900/50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Kuis
                </a>
            </div>
        </div>
    </x-slot>

    <script>
        window.MathJax = {
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']],
                displayMath: [['$$', '$$'], ['\\[', '\\]']]
            },
            svg: {
                fontCache: 'global'
            }
        };
    </script>
    <script type="text/javascript" id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js"></script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-xl sm:rounded-xl p-6 mb-8 border border-gray-700 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl"></div>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative z-10">
                    <div class="md:col-span-3 space-y-4">
                        <div>
                            <h3 class="font-bold text-lg text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Deskripsi
                            </h3>
                            <div class="mt-2 text-gray-300 leading-relaxed bg-gray-900/30 p-4 rounded-lg border border-gray-700/50">
                                {{ $quiz->description ?: 'Tidak ada deskripsi untuk kuis ini.' }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-gray-700 to-gray-800 p-5 rounded-xl text-center border border-gray-600 shadow-lg">
                        <div class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-1">Kode Join</div>
                        <div class="text-3xl font-mono font-bold text-blue-400 tracking-wider bg-gray-900/50 py-2 rounded-lg border border-blue-500/20 select-all cursor-pointer hover:bg-gray-900 transition-colors" onclick="navigator.clipboard.writeText('{{ $quiz->join_code }}'); alert('Kode disalin!')" title="Klik untuk menyalin">
                            {{ $quiz->join_code }}
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 mt-4">
                            <div class="bg-gray-800/50 p-2 rounded-lg">
                                <div class="text-[10px] text-gray-400 uppercase tracking-wider">Waktu</div>
                                <div class="font-bold text-white text-lg">{{ $quiz->timer }} <span class="text-xs font-normal text-gray-500">Menit</span></div>
                            </div>
                            <div class="bg-gray-800/50 p-2 rounded-lg">
                                <div class="text-[10px] text-gray-400 uppercase tracking-wider">Soal</div>
                                <div class="font-bold text-white text-lg">{{ $quiz->questions->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                @foreach($quiz->questions as $index => $question)
                <div class="bg-gray-800 shadow-md sm:rounded-xl p-6 border border-gray-700 hover:border-gray-600 transition-colors duration-200">
                    <div class="flex gap-5">
                        <div class="flex flex-col items-center gap-2 shrink-0">
                            <div class="bg-indigo-600 text-white font-bold w-10 h-10 flex items-center justify-center rounded-lg shadow-lg shadow-indigo-900/30 text-lg border border-indigo-400/20">
                                {{ $index + 1 }}
                            </div>
                            <div class="h-full w-0.5 bg-gray-700 rounded-full"></div>
                        </div>
                        <div class="grow">
                            <div class="text-lg font-medium mb-6 text-gray-100 prose prose-invert max-w-none">
                                {{ $question->question_text }}
                            </div>
                            
                            @if($question->question_type === 'multiple_choice')
                                <div class="grid grid-cols-1 gap-3">
                                    @foreach($question->options as $option)
                                    <div class="group flex items-center p-4 rounded-lg border transition-all duration-200 {{ $option->is_correct ? 'bg-green-900/20 border-green-500/40 hover:bg-green-900/30' : 'bg-gray-700/20 border-gray-600 hover:bg-gray-700/40 hover:border-gray-500' }}">
                                        <div class="flex-shrink-0 mr-4">
                                            @if($option->is_correct)
                                                <div class="w-6 h-6 rounded-full bg-green-500 text-white flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                </div>
                                            @else
                                                <div class="w-6 h-6 rounded-full border-2 border-gray-500 group-hover:border-gray-400"></div>
                                            @endif
                                        </div>
                                        <span class="grow {{ $option->is_correct ? 'font-medium text-green-400' : 'text-gray-300 group-hover:text-gray-200' }}">{{ $option->option_text }}</span>
                                        @if($option->is_correct) 
                                            <span class="ml-3 text-xs bg-green-900/60 text-green-300 px-2.5 py-1 rounded-full border border-green-700/50 font-medium">Jawaban Benar</span> 
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-yellow-900/10 p-4 rounded-lg border border-yellow-600/20 flex items-start gap-3">
                                    <svg class="w-6 h-6 text-yellow-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    <div>
                                        <h4 class="text-yellow-400 font-bold text-sm uppercase tracking-wide mb-1">Soal Essay</h4>
                                        <p class="text-gray-400 text-sm">Jawaban untuk soal ini akan dievaluasi secara manual atau menggunakan AI jika diaktifkan.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>