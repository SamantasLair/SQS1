<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-yellow-500/10 rounded-xl border border-yellow-500/20 shadow-inner">
                    <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">Leaderboard</h2>
                    <p class="text-sm text-indigo-400 mt-1 font-medium">{{ $quiz->title }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('quizzes.show', $quiz) }}" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg font-medium text-xs text-gray-300 uppercase tracking-widest hover:bg-gray-600 hover:text-white transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Kuis
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-xl sm:rounded-xl border border-gray-700 overflow-hidden relative">
                
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-yellow-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="p-6 relative z-10">
                    <div class="overflow-x-auto rounded-lg border border-gray-700">
                        <table class="min-w-full divide-y divide-gray-700">
                            <thead class="bg-gray-900/50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Peringkat</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Peserta</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Skor</th>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Waktu Selesai</th>
                                </tr>
                            </thead>
                            <tbody class="bg-gray-800 divide-y divide-gray-700">
                                @forelse ($attempts as $index => $attempt)
                                    @php
                                        $rank = $attempts->firstItem() + $index;
                                        $rankClass = match($rank) {
                                            1 => 'bg-yellow-500/10 text-yellow-500 border-l-4 border-yellow-500',
                                            2 => 'bg-gray-400/10 text-gray-400 border-l-4 border-gray-400',
                                            3 => 'bg-orange-500/10 text-orange-500 border-l-4 border-orange-500',
                                            default => 'text-gray-300 hover:bg-gray-700/30 border-l-4 border-transparent'
                                        };
                                        
                                        $medal = match($rank) {
                                            1 => '🥇',
                                            2 => '🥈',
                                            3 => '🥉',
                                            default => '#' . $rank
                                        };
                                    @endphp
                                    <tr class="transition-colors duration-200 {{ $rankClass }}">
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-lg">
                                            {{ $medal }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-gray-700 flex items-center justify-center text-sm font-bold text-gray-300 mr-3 border border-gray-600">
                                                    {{ substr($attempt->user->name, 0, 1) }}
                                                </div>
                                                <div class="text-sm font-medium {{ $rank <= 3 ? 'text-white' : 'text-gray-300' }}">
                                                    {{ $attempt->user->name }}
                                                    @if($attempt->user_id === auth()->id())
                                                        <span class="ml-2 px-2 py-0.5 rounded text-[10px] bg-indigo-900 text-indigo-300 border border-indigo-700 uppercase tracking-wide">Anda</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-900 border border-gray-600 {{ $rank <= 3 ? 'text-white' : 'text-gray-300' }}">
                                                {{ number_format($attempt->score, 0) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400 font-mono">
                                            {{ $attempt->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="bg-gray-700/50 p-4 rounded-full mb-3">
                                                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <p class="text-gray-400 font-medium">Belum ada yang mengerjakan kuis ini.</p>
                                                <p class="text-gray-500 text-sm mt-1">Jadilah yang pertama untuk menduduki peringkat teratas!</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <div class="mt-6">
                        {{ $attempts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>