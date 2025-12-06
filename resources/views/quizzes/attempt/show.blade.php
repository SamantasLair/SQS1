<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Detail Kuis') }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('quizzes.index') }}" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition">
                    Kembali
                </a>
                @if($quiz->user_id === auth()->id())
                    <a href="{{ route('quizzes.edit', $quiz) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition shadow-lg shadow-indigo-600/20">
                        Edit Kuis
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 overflow-hidden">
                        <div class="p-8 relative">
                            <div class="absolute top-0 right-0 p-6 opacity-10">
                                <svg class="w-32 h-32 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99zM11 16h2v2h-2zm0-6h2v4h-2z"/></svg>
                            </div>
                            
                            <h1 class="text-3xl font-bold text-white mb-4">{{ $quiz->title }}</h1>
                            <div class="prose prose-invert max-w-none text-gray-300 mb-6">
                                {{ $quiz->description ?? 'Tidak ada deskripsi.' }}
                            </div>

                            <div class="flex flex-wrap gap-4 mt-6">
                                <div class="flex items-center gap-2 bg-gray-900/50 px-4 py-2 rounded-lg border border-gray-600">
                                    <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-gray-300 font-mono">{{ $quiz->timer }} Menit</span>
                                </div>
                                <div class="flex items-center gap-2 bg-gray-900/50 px-4 py-2 rounded-lg border border-gray-600">
                                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-gray-300 font-mono">{{ $quiz->questions->count() }} Soal</span>
                                </div>
                                <div class="flex items-center gap-2 bg-gray-900/50 px-4 py-2 rounded-lg border border-gray-600">
                                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <span class="text-gray-300 font-mono">{{ $quiz->attempts()->count() }} Peserta</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-900/30 p-6 border-t border-gray-700 flex flex-col sm:flex-row gap-4 justify-between items-center">
                            <div class="flex flex-col">
                                <span class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Kode Join</span>
                                <div class="flex items-center gap-3">
                                    <span class="text-3xl font-black text-white tracking-widest">{{ $quiz->join_code }}</span>
                                    <button onclick="navigator.clipboard.writeText('{{ $quiz->join_code }}'); alert('Kode disalin!')" class="text-gray-400 hover:text-white transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="flex gap-3 w-full sm:w-auto">
                                @if($quiz->user_id === auth()->id())
                                    <a href="{{ route('quizzes.analyze', $quiz) }}" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-bold rounded-xl transition shadow-lg shadow-indigo-600/20">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.416H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        Analisis AI
                                    </a>
                                    <a href="{{ route('quizzes.leaderboard', $quiz) }}" class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-bold rounded-xl transition border border-gray-600">
                                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Leaderboard
                                    </a>
                                @else
                                    <a href="{{ route('quizzes.start', $quiz) }}" class="flex-1 sm:flex-none text-center px-8 py-3 bg-green-600 hover:bg-green-500 text-white font-bold rounded-xl transition shadow-lg shadow-green-600/20">
                                        Mulai Kuis
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-gray-800 rounded-xl shadow-lg border border-gray-700 p-6">
                        <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                            Top Leaderboard
                        </h3>
                        
                        <div class="space-y-4">
                            @php
                                $topAttempts = $quiz->attempts()->with('user')->orderByDesc('score')->take(5)->get();
                            @endphp

                            @forelse($topAttempts as $index => $attempt)
                                <div class="flex items-center justify-between p-3 bg-gray-900/50 rounded-lg border border-gray-700">
                                    <div class="flex items-center gap-3">
                                        <span class="font-bold text-gray-500 w-4">#{{ $index + 1 }}</span>
                                        <div class="text-sm">
                                            <div class="font-bold text-white">{{ $attempt->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $attempt->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <span class="font-bold text-indigo-400">{{ number_format($attempt->score, 0) }}</span>
                                </div>
                            @empty
                                <div class="text-center py-6 text-gray-500 text-sm">
                                    Belum ada data.
                                </div>
                            @endforelse
                            
                            @if($topAttempts->count() > 0)
                                <a href="{{ route('quizzes.leaderboard', $quiz) }}" class="block text-center text-sm text-indigo-400 hover:text-indigo-300 mt-4">
                                    Lihat Selengkapnya →
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($quiz->user_id === auth()->id())
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-white mb-6">Daftar Pertanyaan</h3>
                    <div class="space-y-4">
                        @foreach($quiz->questions as $index => $question)
                            <div class="bg-gray-800 rounded-xl border border-gray-700 p-6">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex gap-4">
                                        <span class="flex-shrink-0 w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-gray-300 font-bold">
                                            {{ $index + 1 }}
                                        </span>
                                        <div>
                                            <p class="text-white text-lg font-medium">{{ $question->question_text }}</p>
                                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                @foreach($question->options as $option)
                                                    <div class="flex items-center gap-2 p-3 rounded-lg border {{ $option->is_correct ? 'bg-green-900/20 border-green-500/30' : 'bg-gray-900/30 border-gray-700' }}">
                                                        <div class="w-4 h-4 rounded-full border {{ $option->is_correct ? 'border-green-500 bg-green-500' : 'border-gray-500' }}"></div>
                                                        <span class="{{ $option->is_correct ? 'text-green-300' : 'text-gray-400' }}">{{ $option->option_text }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 bg-gray-700 rounded text-xs text-gray-400 uppercase">
                                        {{ str_replace('_', ' ', $question->question_type) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>