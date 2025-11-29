<x-app-layout>
    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                    Pilih Paket Belajar Anda
                </h2>
                <p class="mt-4 text-xl text-gray-400">
                    Sistem Fair Play: Semua tipe soal terbuka untuk semua. Upgrade untuk kekuatan AI Guru Privat.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8">
                
                <div class="flex flex-col bg-gray-800 rounded-2xl shadow-xl border border-gray-700 p-6 hover:border-gray-600 transition">
                    <h3 class="text-xl font-semibold text-white">Basic</h3>
                    <p class="mt-4 text-gray-400 text-sm">Untuk pemula.</p>
                    <div class="mt-6">
                        <span class="text-4xl font-extrabold text-white">Rp 0</span>
                        <span class="text-base font-medium text-gray-400">/bulan</span>
                    </div>
                    <ul class="mt-6 space-y-4 text-sm text-gray-300 flex-1">
                        <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> 10 Kuis Penyimpanan</li>
                        <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> 3 Kredit AI / hari</li>
                        <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> PG & Essay (Bebas)</li>
                        <li class="flex items-center text-gray-500"><span class="text-red-500 mr-2">✕</span> Analisis AI</li>
                    </ul>
                    <a href="{{ route('register') }}" class="mt-8 block w-full bg-gray-600 border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-gray-700">
                        Daftar Gratis
                    </a>
                </div>

                <div class="flex flex-col bg-gray-800 rounded-2xl shadow-xl border border-blue-500/50 p-6 relative overflow-hidden hover:scale-105 transition">
                    <div class="absolute top-0 right-0 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">EDUKASI</div>
                    <h3 class="text-xl font-semibold text-blue-400">Akademisi</h3>
                    <p class="mt-4 text-gray-400 text-sm">Pelajar & Guru.</p>
                    <div class="mt-6">
                        <span class="text-4xl font-extrabold text-white">Gratis</span>
                        <span class="text-base font-medium text-gray-400">*Verifikasi</span>
                    </div>
                    <ul class="mt-6 space-y-4 text-sm text-gray-300 flex-1">
                        <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> 25 Kuis Penyimpanan</li>
                        <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> 5 Kredit AI / hari</li>
                        <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> PG & Essay (Bebas)</li>
                        <li class="flex items-center"><span class="text-blue-400 mr-2">★</span> Analisis Diagnostik (Siapa lemah dimana)</li>
                    </ul>
                    <button class="mt-8 block w-full bg-blue-600 border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-blue-700">
                        Ajukan Verifikasi
                    </button>
                </div>

                <div class="flex flex-col bg-gray-800 rounded-2xl shadow-2xl border-2 border-indigo-500 p-6 transform scale-105 z-10">
                    <div class="absolute top-0 inset-x-0 h-2 bg-indigo-500 rounded-t-2xl"></div>
                    <h3 class="text-xl font-semibold text-indigo-400">Pro</h3>
                    <p class="mt-4 text-gray-400 text-sm">Bimbel & Kreator.</p>
                    <div class="mt-6">
                        <span class="text-4xl font-extrabold text-white">100rb</span>
                        <span class="text-base font-medium text-gray-400">/bulan</span>
                    </div>
                    <ul class="mt-6 space-y-4 text-sm text-gray-300 flex-1">
                        <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> 50 Kuis Penyimpanan</li>
                        <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> 50 Kredit AI / hari</li>
                        <li class="flex items-center"><span class="text-green-400 mr-2">✓</span> PG & Essay (Bebas)</li>
                        <li class="flex items-center"><span class="text-indigo-400 mr-2">★</span> Analisis Remedial & Saran Materi</li>
                    </ul>
                    <a href="{{ route('payment.checkout', ['plan' => 'pro']) }}" class="mt-8 block w-full bg-indigo-600 border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-indigo-700 shadow-lg shadow-indigo-500/30">
                        Upgrade Pro
                    </a>
                </div>

                <div class="flex flex-col bg-gray-800 rounded-2xl shadow-xl border border-yellow-500/50 p-6 hover:scale-105 transition">
                    <h3 class="text-xl font-semibold text-yellow-400">Premium</h3>
                    <p class="mt-4 text-gray-400 text-sm">Institusi Besar.</p>
                    <div class="mt-6">
                        <span class="text-4xl font-extrabold text-white">250rb</span>
                        <span class="text-base font-medium text-gray-400">/bulan</span>
                    </div>
                    <ul class="mt-6 space-y-4 text-sm text-gray-300 flex-1">
                        <li class="flex items-center"><span class="text-yellow-400 mr-2">★</span> Unlimited Kuis</li>
                        <li class="flex items-center"><span class="text-yellow-400 mr-2">★</span> Unlimited AI</li>
                        <li class="flex items-center"><span class="text-yellow-400 mr-2">★</span> Full Insight & Psikometrik</li>
                        <li class="flex items-center"><span class="text-yellow-400 mr-2">★</span> Prioritas Support</li>
                    </ul>
                    <a href="{{ route('payment.checkout', ['plan' => 'premium']) }}" class="mt-8 block w-full bg-gradient-to-r from-yellow-600 to-yellow-500 border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:from-yellow-500 hover:to-yellow-400">
                        Jadi Sultan
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>