<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-white mb-2">Bergabung ke Kuis</h2>
        <p class="text-indigo-200 text-sm">Masukkan kode unik kuis untuk mulai mengerjakan.</p>
    </div>

    <form method="POST" action="{{ route('quizzes.join.store') }}" class="space-y-6">
        @csrf

        <div>
            <label for="join_code" class="block text-sm font-medium text-gray-300 mb-2 text-center">Kode Kuis</label>
            <div class="relative group">
                <input id="join_code" class="block w-full px-4 py-4 bg-gray-900/50 border border-gray-600 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all font-mono text-2xl tracking-[0.25em] text-center uppercase" 
                       type="text" name="join_code" :value="old('join_code')" required autofocus placeholder="CODE123" />
            </div>
            <x-input-error :messages="$errors->get('join_code')" class="mt-2" />
        </div>

        @if(!Auth::check())
        <div>
            <label for="guest_name" class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <input id="guest_name" class="block w-full pl-12 pr-4 py-3 bg-gray-900/50 border border-gray-600 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" 
                       type="text" name="guest_name" :value="old('guest_name')" required placeholder="Masukkan nama Anda" />
            </div>
            <x-input-error :messages="$errors->get('guest_name')" class="mt-2" />
        </div>
        @else
        <div class="p-4 bg-indigo-900/20 border border-indigo-500/30 rounded-xl flex items-center gap-4">
            <div class="h-12 w-12 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-xl shadow-lg">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div>
                <p class="text-indigo-300 text-xs uppercase tracking-wider font-semibold mb-0.5">Masuk Sebagai</p>
                <p class="text-white font-bold text-lg leading-tight">{{ Auth::user()->name }}</p>
            </div>
        </div>
        <input type="hidden" name="user_auth" value="1">
        @endif

        <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-500/20 text-base font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-gray-900 transform hover:scale-[1.02] transition-all duration-200">
            Mulai Mengerjakan
        </button>
    </form>
</x-guest-layout>