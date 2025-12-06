<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-500/10 rounded-xl border border-indigo-500/20 shadow-inner">
                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl text-white leading-tight tracking-tight">Analisis AI</h2>
                    <p class="text-sm text-indigo-400 mt-1 font-medium">{{ $quiz->title }}</p>
                </div>
            </div>
            
            <a href="{{ route('quizzes.show', $quiz) }}" class="inline-flex items-center px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg font-medium text-xs text-gray-300 uppercase tracking-widest hover:bg-gray-600 hover:text-white transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(isset($error))
                <div class="bg-red-900/20 border border-red-500/50 rounded-xl p-6 text-center">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-red-500/20 rounded-full mb-4">
                        <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-red-300 mb-2">Akses Dibatasi atau Data Kurang</h3>
                    <p class="text-gray-400 max-w-lg mx-auto">{{ $error }}</p>
                    
                    @if(!Auth::user()->is_premium && !Auth::user()->role)
                        <div class="mt-6">
                            <a href="{{ route('pricing.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl font-bold text-white shadow-lg hover:scale-105 transition-transform">
                                Upgrade Paket
                            </a>
                        </div>
                    @endif
                </div>
            @elseif(isset($analysis))
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                        <div class="text-gray-400 text-sm font-medium mb-1">Level Analisis</div>
                        <div class="text-2xl font-bold text-white capitalize">{{ str_replace('_', ' ', $level ?? 'Standard') }}</div>
                    </div>
                    <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                        <div class="text-gray-400 text-sm font-medium mb-1">Status</div>
                        <div class="text-2xl font-bold text-green-400 flex items-center gap-2">
                            <span class="relative flex h-3 w-3">
                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                              <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                            </span>
                            Selesai
                        </div>
                    </div>
                </div>

                <div class="bg-gray-800 rounded-xl border border-gray-700 shadow-xl overflow-hidden">
                    <div class="p-6 border-b border-gray-700 bg-gray-900/50 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Insight & Rekomendasi</h3>
                    </div>
                    <div class="p-8 prose prose-invert max-w-none prose-headings:text-indigo-300 prose-strong:text-white prose-li:text-gray-300">
                        {!! nl2br(e($analysis)) !!}
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>