<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 text-center">
                @if($existing->status === 'pending')
                    <div class="text-yellow-500 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-100 mb-2">Pengajuan Sedang Ditinjau</h2>
                    <p class="text-gray-400">Kami sedang memverifikasi data Anda di {{ $existing->institution_name }}. Proses ini biasanya memakan waktu 1x24 jam.</p>
                @else
                    <div class="text-green-500 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-100 mb-2">Akun Terverifikasi</h2>
                    <p class="text-gray-400">Selamat! Akun Anda sudah berstatus Akademisi.</p>
                @endif
                
                <div class="mt-6">
                    <a href="{{ route('dashboard') }}" class="text-indigo-400 hover:text-indigo-300">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>