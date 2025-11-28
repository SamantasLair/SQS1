<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white tracking-tight drop-shadow-md">
            Gabung Kuis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 overflow-hidden shadow-2xl sm:rounded-2xl p-8 text-center">
                
                <div class="mb-8 flex justify-center">
                    <div class="p-4 bg-indigo-500/20 rounded-full text-indigo-400">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path></svg>
                    </div>
                </div>

                <form action="{{ route('quizzes.join.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="code" class="block font-bold text-lg text-white mb-4">Masukkan Kode Kuis</label>
                        <input type="text" name="code" id="code" class="block w-full text-center text-4xl font-mono tracking-[0.5em] font-bold rounded-xl shadow-lg border-gray-600 bg-black/30 text-white focus:border-indigo-500 focus:ring-indigo-500 uppercase py-4" required maxlength="6" minlength="6" placeholder="XXXXXX">
                        
                        @if(session('error'))
                            <p class="text-sm text-red-400 mt-4 font-semibold bg-red-500/10 py-2 rounded-lg border border-red-500/20">{{ session('error') }}</p>
                        @endif
                    </div>
                    
                    <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-4 bg-indigo-600 border border-transparent rounded-xl font-bold text-white text-lg uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg transform hover:scale-[1.02]">
                        Masuk Ruang Kuis
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>