<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white tracking-tight drop-shadow-md">
            Dashboard Utama
        </h2>
    </x-slot>

    <div class="space-y-8">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-violet-600/80 via-indigo-600/80 to-purple-600/80 p-8 shadow-2xl backdrop-blur-sm border border-white/10">
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="text-white">
                    <h3 class="text-4xl font-black tracking-tight mb-2">Halo, {{ Auth::user()->name }}!</h3>
                    <p class="text-indigo-100 text-lg font-light">Hari yang indah untuk belajar sesuatu yang baru.</p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('quizzes.create') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-700 font-bold rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 transition transform duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Buat Kuis
                    </a>
                    <a href="{{ route('quizzes.join.show') }}" class="inline-flex items-center px-6 py-3 bg-black/30 text-white font-bold rounded-2xl border border-white/30 backdrop-blur-md hover:bg-black/50 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        Gabung
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white/5 backdrop-blur-md rounded-3xl p-6 border border-white/10 hover:bg-white/10 transition-colors duration-300">
                <div class="flex items-center">
                    <div class="p-4 rounded-2xl bg-blue-500/20 text-blue-400 mr-5">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-400">Total Kuis Saya</p>
                        <p class="text-3xl font-bold text-white">{{ $totalKuis }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 backdrop-blur-md rounded-3xl p-6 border border-white/10 hover:bg-white/10 transition-colors duration-300">
                <div class="flex items-center">
                    <div class="p-4 rounded-2xl bg-purple-500/20 text-purple-400 mr-5">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-400">Kuis Dikerjakan</p>
                        <p class="text-3xl font-bold text-white">{{ $kuisDikerjakan }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 backdrop-blur-md rounded-3xl p-6 border border-white/10 hover:bg-white/10 transition-colors duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 p-4 opacity-10">
                    <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <p class="text-sm font-medium text-gray-400 mb-1">Kuota Kuis</p>
                <p class="text-3xl font-bold text-white">
                    {{ Auth::user()->quizzes()->count() }} <span class="text-lg text-gray-500 font-normal">/ {{ Auth::user()->getQuizLimit() }}</span>
                </p>
                @if(Auth::user()->quizzes()->count() >= Auth::user()->getQuizLimit())
                    <div class="text-xs text-red-400 mt-2 font-bold bg-red-900/20 px-2 py-1 rounded inline-block">Limit Tercapai</div>
                @else
                    <div class="text-xs text-green-400 mt-2 bg-green-900/20 px-2 py-1 rounded inline-block">Tersedia</div>
                @endif
            </div>

            <div class="bg-white/5 backdrop-blur-md rounded-3xl p-6 border border-white/10 hover:bg-white/10 transition-colors duration-300 relative overflow-hidden">
                <div class="absolute right-0 top-0 p-4 opacity-10">
                    <svg class="w-12 h-12 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <p class="text-sm font-medium text-gray-400 mb-1">Kuota AI Harian</p>
                @if(Auth::user()->is_premium)
                    <p class="text-2xl font-bold text-purple-400">UNLIMITED</p>
                    <div class="text-xs text-gray-500 mt-2">Akun Premium</div>
                @else
                    @php
                        Auth::user()->consumeAiCredit(); 
                        Auth::user()->decrement('ai_usage_count');
                    @endphp
                    <p class="text-3xl font-bold text-white">
                        {{ Auth::user()->ai_usage_count }} <span class="text-lg text-gray-500 font-normal">/ {{ Auth::user()->getAiDailyLimit() }}</span>
                    </p>
                    <div class="text-xs text-gray-500 mt-2">Reset tiap hari</div>
                @endif
            </div>
        </div>

        <div class="bg-white/5 backdrop-blur-xl rounded-3xl border border-white/10 overflow-hidden shadow-2xl">
            <div class="p-8 border-b border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
                <div>
                    <h3 class="text-xl font-bold text-white">Aktivitas Terbaru</h3>
                    <p class="text-sm text-gray-400">Daftar kuis yang baru saja ditambahkan ke sistem.</p>
                </div>
                <a href="{{ route('quizzes.index') }}" class="text-sm font-bold text-indigo-400 hover:text-indigo-300 flex items-center transition-colors">
                    Lihat Semua
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-black/20 text-gray-400">
                        <tr>
                            <th class="px-8 py-5 text-left text-xs font-bold uppercase tracking-wider">Judul Kuis</th>
                            <th class="px-8 py-5 text-left text-xs font-bold uppercase tracking-wider">Pembuat</th>
                            <th class="px-8 py-5 text-left text-xs font-bold uppercase tracking-wider">Durasi</th>
                            <th class="px-8 py-5 text-left text-xs font-bold uppercase tracking-wider">Kode</th>
                            <th class="px-8 py-5 text-right text-xs font-bold uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($kuisTerbaru as $quiz)
                        <tr class="hover:bg-white/5 transition-colors duration-150 group">
                            <td class="px-8 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold shadow-lg">
                                        {{ substr($quiz->title, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-white group-hover:text-indigo-300 transition-colors">{{ Str::limit($quiz->title, 30) }}</div>
                                        <div class="text-xs text-gray-500">{{ Str::limit($quiz->description, 40) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white/10 text-gray-300 border border-white/5">
                                    {{ $quiz->user->name }}
                                </span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-400">
                                {{ $quiz->timer }} Menit
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <span class="font-mono text-sm text-indigo-400 tracking-wider bg-indigo-500/10 px-2 py-1 rounded">
                                    {{ $quiz->join_code }}
                                </span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-3">
                                    @if(Auth::id() === $quiz->user_id)
                                        <a href="{{ route('quizzes.leaderboard', $quiz) }}" class="p-2 rounded-lg text-gray-500 hover:text-yellow-400 hover:bg-white/5 transition-all" title="Leaderboard">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        </a>
                                        <a href="{{ route('quizzes.edit', $quiz) }}" class="p-2 rounded-lg text-gray-500 hover:text-blue-400 hover:bg-white/5 transition-all" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                    @endif
                                    <a href="{{ route('quizzes.start', $quiz) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg shadow-indigo-600/20">
                                        Mulai
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-8 py-16 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-600 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="text-lg">Belum ada kuis yang tersedia saat ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>