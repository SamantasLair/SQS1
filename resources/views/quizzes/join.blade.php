<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Masukkan kode kuis untuk mulai mengerjakan.') }}
    </div>

    <form method="POST" action="{{ route('quizzes.join.store') }}">
        @csrf

        <div>
            <x-input-label for="join_code" :value="__('Kode Kuis')" />
            <x-text-input id="join_code" class="block mt-1 w-full font-mono text-center text-lg tracking-widest uppercase" 
                          type="text" name="join_code" :value="old('join_code')" required autofocus placeholder="ABC123" />
            <x-input-error :messages="$errors->get('join_code')" class="mt-2" />
        </div>

        @if(!Auth::check())
        <div class="mt-4">
            <x-input-label for="guest_name" :value="__('Nama Anda (Mode Tamu)')" />
            <x-text-input id="guest_name" class="block mt-1 w-full" 
                          type="text" name="guest_name" :value="old('guest_name')" required placeholder="Masukkan nama lengkap" />
            <x-input-error :messages="$errors->get('guest_name')" class="mt-2" />
            <p class="text-xs text-gray-500 mt-1">Anda mengerjakan sebagai tamu. Riwayat tidak akan tersimpan di akun.</p>
        </div>
        @else
        <div class="mt-4 p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg flex items-center gap-3">
            <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xs">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="text-sm">
                <p class="text-gray-500 dark:text-gray-400 text-xs">Masuk sebagai:</p>
                <p class="font-bold text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</p>
            </div>
        </div>
        <input type="hidden" name="user_auth" value="1">
        @endif

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3 w-full justify-center">
                {{ __('Masuk Kuis') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>