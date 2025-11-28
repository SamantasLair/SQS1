<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-white tracking-tight drop-shadow-md">
                Kuis Saya
            </h2>
            <div class="flex items-center gap-3">
                @if(!Auth::user()->is_premium)
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 px-4 py-2 rounded-full text-xs font-medium text-indigo-200">
                    Limit AI Harian: {{ Auth::user()->ai_usage_count }}/3
                </div>
                @else
                <div class="bg-gradient-to-r from-amber-400 to-yellow-600 px-4 py-2 rounded-full text-xs font-bold text-white shadow-lg flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    PREMIUM USER
                </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-white/5 backdrop-blur-xl rounded-3xl p-6 border border-white/10 shadow-2xl">
            <div>
                <h3 class="text-xl font-bold text-white mb-1">Kelola Perpustakaan Kuis</h3>
                <p class="text-indigo-200 text-sm">Buat, edit, dan pantau performa kuis Anda di sini.</p>
            </div>
            <a href="{{ route('quizzes.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-indigo-600 font-bold rounded-xl shadow-lg hover:bg-gray-50 hover:scale-105 transition transform duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Kuis Baru
            </a>
        </div>

        <div class="grid grid-cols-1 gap-4">
            @forelse ($quizzes as $quiz)
                <div class="group relative bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all duration-300 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-lg font-bold text-white group-hover:text-indigo-300 transition-colors">{{ $quiz->title }}</h3>
                            @if($quiz->generation_source === 'ai')
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-purple-500/20 text-purple-300 border border-purple-500/30">AI Generated</span>
                            @endif
                        </div>
                        <p class="text-gray-400 text-sm mb-3 line-clamp-1">{{ $quiz->description ?? 'Tidak ada deskripsi.' }}</p>
                        
                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-400">
                            <div class="flex items-center bg-black/20 px-2 py-1 rounded-md">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $quiz->timer }} Menit
                            </div>
                            @if($quiz->join_code)
                            <div class="flex items-center bg-indigo-500/10 border border-indigo-500/30 text-indigo-300 px-2 py-1 rounded-md font-mono">
                                CODE: {{ $quiz->join_code }}
                            </div>
                            @endif
                            <div class="flex items-center bg-black/20 px-2 py-1 rounded-md">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $quiz->questions->count() }} Soal
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                        <a href="{{ route('quizzes.leaderboard', $quiz) }}" class="p-2 text-gray-400 hover:text-yellow-400 hover:bg-white/5 rounded-lg transition-colors" title="Leaderboard">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </a>
                        <a href="{{ route('quizzes.start', $quiz) }}" class="p-2 text-gray-400 hover:text-green-400 hover:bg-white/5 rounded-lg transition-colors" title="Test Run">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </a>
                        <a href="{{ route('quizzes.edit', $quiz) }}" class="p-2 text-gray-400 hover:text-blue-400 hover:bg-white/5 rounded-lg transition-colors" title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kuis ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-400 hover:bg-white/5 rounded-lg transition-colors" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white/5 backdrop-blur-md rounded-2xl p-12 text-center border border-white/10 border-dashed">
                    <div class="flex flex-col items-center justify-center">
                        <div class="bg-white/10 p-4 rounded-full mb-4">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <p class="text-lg text-gray-300 font-medium">Belum ada kuis yang dibuat.</p>
                        <p class="text-gray-500 text-sm mt-1">Mulai dengan membuat kuis baru sekarang.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>