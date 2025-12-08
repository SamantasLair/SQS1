<x-app-layout>
    @php
        $totalAttempts = $quiz->attempts()->whereNotNull('score')->count();
        $avgScore = $totalAttempts > 0 ? $quiz->attempts()->whereNotNull('score')->avg('score') : 0;
        $highestScore = $totalAttempts > 0 ? $quiz->attempts()->whereNotNull('score')->max('score') : 0;
        
        $myAttempt = null;
        if(Auth::check()) {
            $myAttempt = $quiz->attempts()->where('user_id', Auth::id())->whereNotNull('score')->latest()->first();
        } elseif(session('guest_name')) {
            $myAttempt = $quiz->attempts()->where('guest_name', session('guest_name'))->whereNotNull('score')->latest()->first();
        }

        $questionStats = [];
        foreach($quiz->questions as $q) {
            $correct = $q->userAnswers()->where('is_correct', true)->count();
            $totalAns = $q->userAnswers()->count();
            $wrong = $totalAns - $correct;
            
            $myStatus = 'neutral'; 
            if($myAttempt) {
                $myAns = $myAttempt->answers()->where('question_id', $q->id)->first();
                if($myAns) {
                    $myStatus = $myAns->is_correct ? 'correct' : 'wrong';
                }
            }

            $questionStats[] = [
                'id' => $q->id,
                'text' => $q->question_text,
                'correct' => $correct,
                'wrong' => $wrong,
                'total' => $totalAns,
                'my_status' => $myStatus
            ];
        }
    @endphp

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-yellow-500/10 rounded-xl border border-yellow-500/20 shadow-inner">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">Leaderboard & Analisis</h2>
                    <p class="text-indigo-400 text-sm mt-1 font-medium">{{ $quiz->title }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @if(Auth::check() && Auth::id() === $quiz->user_id)
                    <form action="{{ route('quizzes.reset', $quiz) }}" method="POST" onsubmit="return confirm('Reset semua hasil peserta? Data tidak bisa dikembalikan.');">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg">
                            Reset Hasil
                        </button>
                    </form>
                    
                    <a href="{{ route('quizzes.analyze', $quiz) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:from-purple-500 hover:to-indigo-500 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg shadow-purple-900/50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Analisis AI
                    </a>
                @endif

                @if($myAttempt)
                    <form action="{{ route('quizzes.retake', $quiz) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Mulai Ulang
                        </button>
                    </form>
                @elseif(Auth::check() || session('guest_name'))
                    <a href="{{ route('quizzes.start', $quiz) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Mulai
                    </a>
                @endif

                <a href="{{ route('quizzes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg font-medium text-xs text-gray-300 uppercase tracking-widest hover:bg-gray-600 hover:text-white transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-lg relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Total Partisipan</p>
                    <p class="text-4xl font-black text-white mt-2">{{ $totalAttempts }}</p>
                </div>

                <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-lg relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Rata-Rata Skor</p>
                    <div class="flex items-end gap-2 mt-2">
                        <p class="text-4xl font-black text-white">{{ number_format($avgScore, 1) }}</p>
                        <span class="text-sm text-gray-500 mb-1">/ 100</span>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-lg relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10">
                        <svg class="w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Skor Tertinggi</p>
                    <p class="text-4xl font-black text-white mt-2">{{ number_format($highestScore, 0) }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    @if($attempts->count() >= 3)
                    <div class="bg-gray-800/50 rounded-3xl border border-gray-700 p-8 flex justify-center items-end gap-4 shadow-2xl relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-b from-indigo-900/10 to-transparent pointer-events-none"></div>
                        
                        <div class="flex flex-col items-center w-1/3 max-w-[140px] relative z-10">
                            <div class="relative mb-2">
                                <div class="w-16 h-16 rounded-full border-4 border-gray-400 bg-gray-700 flex items-center justify-center overflow-hidden shadow-lg shadow-gray-500/20">
                                    <span class="text-xl font-bold text-gray-300">{{ substr($attempts[1]->user->name ?? $attempts[1]->guest_name, 0, 1) }}</span>
                                </div>
                                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-gray-400 text-gray-900 text-xs font-bold px-2 py-0.5 rounded-full border border-gray-300">2nd</div>
                            </div>
                            <div class="text-center mb-2 w-full">
                                <div class="font-bold text-gray-200 text-sm truncate w-full px-1">{{ $attempts[1]->user->name ?? $attempts[1]->guest_name }}</div>
                                <div class="text-indigo-400 font-bold">{{ number_format($attempts[1]->score) }}</div>
                            </div>
                            <div class="w-full h-32 bg-gradient-to-t from-gray-700 to-gray-600 rounded-t-lg shadow-2xl border-t border-gray-500 opacity-80"></div>
                        </div>

                        <div class="flex flex-col items-center w-1/3 max-w-[160px] z-20 -mb-2">
                            <div class="relative mb-3">
                                <div class="absolute -top-6 left-1/2 transform -translate-x-1/2 text-3xl animate-bounce">👑</div>
                                <div class="w-20 h-20 rounded-full border-4 border-yellow-400 bg-gray-700 flex items-center justify-center overflow-hidden shadow-lg shadow-yellow-500/30">
                                    <span class="text-2xl font-bold text-yellow-400">{{ substr($attempts[0]->user->name ?? $attempts[0]->guest_name, 0, 1) }}</span>
                                </div>
                                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-0.5 rounded-full border border-yellow-200">1st</div>
                            </div>
                            <div class="text-center mb-2 w-full">
                                <div class="font-bold text-white text-base truncate w-full px-1">{{ $attempts[0]->user->name ?? $attempts[0]->guest_name }}</div>
                                <div class="text-yellow-400 font-black text-lg">{{ number_format($attempts[0]->score) }}</div>
                            </div>
                            <div class="w-full h-40 bg-gradient-to-t from-yellow-600 to-yellow-500 rounded-t-lg shadow-2xl border-t border-yellow-300 relative overflow-hidden">
                                <div class="absolute inset-0 bg-white/10"></div>
                            </div>
                        </div>

                        <div class="flex flex-col items-center w-1/3 max-w-[140px]">
                            <div class="relative mb-2">
                                <div class="w-16 h-16 rounded-full border-4 border-orange-600 bg-gray-800 flex items-center justify-center overflow-hidden shadow-lg shadow-orange-500/20">
                                    <span class="text-xl font-bold text-orange-500">{{ substr($attempts[2]->user->name ?? $attempts[2]->guest_name, 0, 1) }}</span>
                                </div>
                                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-orange-600 text-orange-100 text-xs font-bold px-2 py-0.5 rounded-full border border-orange-400">3rd</div>
                            </div>
                            <div class="text-center mb-2 w-full">
                                <div class="font-bold text-gray-200 text-sm truncate w-full px-1">{{ $attempts[2]->user->name ?? $attempts[2]->guest_name }}</div>
                                <div class="text-indigo-400 font-bold">{{ number_format($attempts[2]->score) }}</div>
                            </div>
                            <div class="w-full h-24 bg-gradient-to-t from-orange-800 to-orange-700 rounded-t-lg shadow-2xl border-t border-orange-500 opacity-80"></div>
                        </div>
                    </div>
                    @endif

                    <div class="bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-700 bg-gray-900/50">
                            <h3 class="text-lg font-bold text-white">Semua Peringkat</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-900/50 text-gray-400 uppercase text-xs">
                                    <tr>
                                        <th class="px-6 py-4 font-bold tracking-wider w-16">Rank</th>
                                        <th class="px-6 py-4 font-bold tracking-wider">Peserta</th>
                                        <th class="px-6 py-4 font-bold tracking-wider text-center">Ketepatan</th>
                                        <th class="px-6 py-4 font-bold tracking-wider text-right">Skor</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-700">
                                    @forelse($attempts as $index => $attempt)
                                        @php
                                            $rank = $attempts->firstItem() + $index;
                                            
                                            $isMe = false;
                                            if (Auth::check() && $attempt->user_id === Auth::id()) {
                                                $isMe = true;
                                            } elseif (!Auth::check() && session('guest_name') && $attempt->guest_name === session('guest_name')) {
                                                $isMe = true;
                                            }

                                            $totalQ = $quiz->questions->count();
                                            $correctQ = $attempt->answers->filter(fn($a) => $a->is_correct)->count();
                                            $accuracy = $totalQ > 0 ? round(($correctQ / $totalQ) * 100) : 0;
                                        @endphp
                                        <tr class="hover:bg-white/5 transition-colors {{ $isMe ? 'bg-indigo-900/30 border-l-4 border-indigo-500' : 'border-l-4 border-transparent' }}">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="font-mono font-bold {{ $rank <= 3 ? 'text-yellow-400 text-lg' : 'text-gray-500' }}">
                                                    #{{ $rank }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-xs font-bold text-gray-300 border border-gray-600">
                                                        {{ substr($attempt->user->name ?? $attempt->guest_name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-white text-sm flex items-center gap-2">
                                                            {{ $attempt->user->name ?? $attempt->guest_name }}
                                                            @if($isMe) <span class="text-[10px] bg-indigo-500 text-white px-1.5 rounded font-bold">YOU</span> @endif
                                                        </div>
                                                        <div class="text-xs text-gray-500">{{ $attempt->created_at->diffForHumans() }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex flex-col items-center">
                                                    <div class="w-full bg-gray-700 rounded-full h-1.5 w-24 mb-1 overflow-hidden">
                                                        <div class="bg-gradient-to-r from-green-500 to-emerald-400 h-1.5 rounded-full" style="width: {{ $accuracy }}%"></div>
                                                    </div>
                                                    <span class="text-xs text-gray-400 font-mono">{{ $correctQ }}/{{ $totalQ }} Benar</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="font-black text-lg text-white">{{ number_format($attempt->score) }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                                Belum ada data leaderboard.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($attempts->hasPages())
                            <div class="p-4 border-t border-gray-700 bg-gray-800">
                                {{ $attempts->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-gray-800 rounded-2xl shadow-xl border border-gray-700 overflow-hidden sticky top-6">
                        <div class="p-6 border-b border-gray-700 bg-gray-900/50 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-white">Statistik Soal</h3>
                            <span class="text-xs bg-gray-700 text-gray-300 px-2 py-1 rounded">{{ count($questionStats) }} Soal</span>
                        </div>
                        <div class="p-6 space-y-6 max-h-[80vh] overflow-y-auto custom-scrollbar">
                            @foreach($questionStats as $index => $stat)
                                <div class="group {{ $index >= 5 ? 'hidden extra-questions' : '' }} p-3 rounded-lg border 
                                    @if($stat['my_status'] === 'correct') border-green-500/30 bg-green-900/10 
                                    @elseif($stat['my_status'] === 'wrong') border-red-500/30 bg-red-900/10 
                                    @else border-transparent hover:bg-gray-700/30 
                                    @endif transition-colors">
                                    
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex gap-2">
                                            <span class="font-mono text-sm {{ $stat['my_status'] === 'correct' ? 'text-green-400' : ($stat['my_status'] === 'wrong' ? 'text-red-400' : 'text-gray-500') }}">
                                                #{{ $index + 1 }}
                                            </span>
                                            <p class="text-sm text-gray-300 line-clamp-2 leading-snug">{{ $stat['text'] }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="relative h-2 bg-gray-700 rounded-full overflow-hidden flex">
                                        @php
                                            $total = $stat['total'];
                                            $correctP = $total > 0 ? ($stat['correct'] / $total) * 100 : 0;
                                            $wrongP = $total > 0 ? ($stat['wrong'] / $total) * 100 : 0;
                                        @endphp
                                        @if($total > 0)
                                            <div class="h-full bg-green-500" style="width: {{ $correctP }}%"></div>
                                            <div class="h-full bg-red-500" style="width: {{ $wrongP }}%"></div>
                                        @else
                                            <div class="h-full bg-gray-600 w-full"></div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex justify-between text-xs mt-1.5 font-medium">
                                        <span class="text-green-400">{{ $stat['correct'] }} Benar</span>
                                        <span class="text-red-400">{{ $stat['wrong'] }} Salah</span>
                                    </div>
                                </div>
                            @endforeach

                            @if(count($questionStats) > 5)
                                <button onclick="toggleQuestions()" id="toggleBtn" class="w-full py-2 text-sm text-indigo-400 hover:text-indigo-300 font-medium border border-dashed border-indigo-500/30 rounded-lg hover:bg-indigo-500/10 transition-colors">
                                    Lihat {{ count($questionStats) - 5 }} Soal Lainnya
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleQuestions() {
            const hiddenItems = document.querySelectorAll('.extra-questions');
            const btn = document.getElementById('toggleBtn');
            
            hiddenItems.forEach(item => {
                item.classList.toggle('hidden');
            });

            if (btn.innerText.includes('Lihat')) {
                btn.innerText = 'Sembunyikan';
            } else {
                btn.innerText = 'Lihat {{ count($questionStats) - 5 }} Soal Lainnya';
            }
        }
    </script>
</x-app-layout>