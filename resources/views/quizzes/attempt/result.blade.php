<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-2">
            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Hasil Kuis: {{ $attempt->quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-xl sm:rounded-2xl p-8 border border-gray-700 relative overflow-hidden">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-lg bg-indigo-500/10 blur-3xl rounded-full pointer-events-none"></div>

                <div class="relative z-10 text-center space-y-8">
                    
                    <div>
                        <h3 class="text-3xl font-bold text-white mb-2">Kuis Selesai!</h3>
                        <p class="text-gray-400">Terima kasih telah mengerjakan kuis ini.</p>
                    </div>

                    <div class="py-8">
                        <div class="inline-block relative">
                            <svg class="w-48 h-48 text-indigo-600/20" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="45" fill="currentColor" />
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-sm text-indigo-300 font-bold uppercase tracking-wider">Skor Anda</span>
                                <span class="text-6xl font-black text-white drop-shadow-lg">{{ number_format($score, 0) }}</span>
                            </div>
                        </div>
                        
                        <div class="mt-6 flex justify-center gap-4 text-sm">
                            <div class="px-4 py-2 rounded-lg bg-green-900/30 border border-green-500/30 text-green-400 font-medium">
                                <span class="font-bold text-lg mr-1">{{ $correctAnswers }}</span> Benar
                            </div>
                            <div class="px-4 py-2 rounded-lg bg-gray-700/50 border border-gray-600 text-gray-300 font-medium">
                                <span class="font-bold text-lg mr-1">{{ $totalQuestions }}</span> Total Soal
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4 border-t border-gray-700/50">
                        <a href="{{ route('quizzes.index') }}" class="inline-flex justify-center items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Kuis Saya
                        </a>
                        <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center px-6 py-3 bg-gray-700 border border-gray-600 rounded-xl font-bold text-gray-300 uppercase tracking-widest hover:bg-gray-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition ease-in-out duration-150">
                            Ke Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>