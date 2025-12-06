<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Quiz Semalam (SQS)</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/tsparticles-slim@2.0.6/tsparticles.slim.bundle.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-900 text-gray-100 overflow-x-hidden selection:bg-indigo-500 selection:text-white">
        
        <div id="tsparticles-welcome" class="fixed inset-0 z-0 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col min-h-screen">
            
            <header class="fixed w-full z-50 transition-all duration-300 bg-gray-900/80 backdrop-blur-lg border-b border-white/10">
                <nav class="container mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <div class="flex items-center gap-3">
                            <a href="#" class="flex items-center gap-3">
                                <div class="flex items-center justify-center h-10 w-10 bg-gradient-to-tr from-indigo-500 to-purple-600 rounded-xl shadow-lg shadow-indigo-500/20">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <span class="text-2xl font-bold text-white tracking-wider">SQS</span>
                            </a>
                        </div>
                        
                        <div class="hidden md:flex items-center space-x-8">
                            <a href="#home" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Home</a>
                            <a href="#mengapa" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Mengapa Kami</a>
                            <a href="#keunggulan" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Keunggulan</a>
                            <a href="#populer" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Kuis Populer</a>
                            <a href="{{ route('pricing.index') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Harga</a>
                            <a href="#tentang" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Tentang Kami</a>
                        </div>

                        <div class="flex items-center gap-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 border border-white/10 rounded-xl font-semibold text-sm text-white transition-all duration-200">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition-colors">
                                        Masuk
                                    </a>
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-semibold text-sm shadow-lg shadow-indigo-600/30 transition-all duration-200 transform hover:scale-105">
                                        Daftar Gratis
                                    </a>
                                @endauth
                            @endif
                        </div>
                    </div>
                </nav>
            </header>

            <main class="flex-grow pt-20">
                
                <section id="home" class="relative py-20 sm:py-32 overflow-hidden">
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-purple-600/30 rounded-full blur-[120px] pointer-events-none"></div>
                    <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-indigo-600/20 rounded-full blur-[100px] pointer-events-none"></div>

                    <div class="container mx-auto max-w-7xl px-6 lg:px-8 relative z-10 text-center">
                        <h1 class="text-5xl sm:text-7xl font-extrabold text-white tracking-tight leading-tight mb-8">
                            Uji Pengetahuan Anda <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400">Raih Hasil Maksimal</span>
                        </h1>
                        <p class="mt-6 text-lg sm:text-xl text-gray-400 max-w-2xl mx-auto mb-10">
                            Kelola materi ujian dengan sistem yang terstruktur. Bagikan kode unik kepada peserta, kerjakan soal, dan pantau hasil evaluasi secara mendalam.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-600/30 hover:shadow-2xl hover:scale-105 transition-all duration-300 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Mulai Sekarang
                            </a>
                            <a href="#mengapa" class="px-8 py-4 bg-white/5 border border-white/10 text-white font-semibold rounded-2xl hover:bg-white/10 backdrop-blur-sm transition-all duration-300">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>
                        <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-8 max-w-4xl mx-auto border-t border-white/10 pt-10">
                            <div>
                                <h3 class="text-3xl font-bold text-white mb-1">10k+</h3>
                                <p class="text-gray-500 text-sm">Pengguna Aktif</p>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold text-white mb-1">50k+</h3>
                                <p class="text-gray-500 text-sm">Kuis Dibuat</p>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold text-white mb-1">1M+</h3>
                                <p class="text-gray-500 text-sm">Bank Soal</p>
                            </div>
                            <div>
                                <h3 class="text-3xl font-bold text-white mb-1">4.9</h3>
                                <p class="text-gray-500 text-sm">Rating Rata-rata</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="mengapa" class="py-24 bg-black/20 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-indigo-500/50 to-transparent"></div>
                    
                    <div class="container mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="text-center max-w-3xl mx-auto mb-16">
                            <h2 class="text-3xl font-bold text-white mb-6">Mengapa Memilih SQS?</h2>
                            <p class="text-gray-400 text-lg">Kami menyediakan sistem manajemen evaluasi yang handal dan mudah digunakan untuk pengalaman belajar yang optimal.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="p-8 rounded-3xl bg-gradient-to-b from-white/5 to-transparent border border-white/10 hover:border-indigo-500/50 transition-colors duration-300">
                                <div class="w-14 h-14 bg-indigo-500/20 rounded-2xl flex items-center justify-center text-indigo-400 mb-6">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3">Manajemen Materi</h3>
                                <p class="text-gray-400 leading-relaxed">Susun materi ujian dengan format yang fleksibel dan terorganisir. Simpan bank soal Anda untuk digunakan kembali kapan saja.</p>
                            </div>

                            <div class="p-8 rounded-3xl bg-gradient-to-b from-white/5 to-transparent border border-white/10 hover:border-purple-500/50 transition-colors duration-300">
                                <div class="w-14 h-14 bg-purple-500/20 rounded-2xl flex items-center justify-center text-purple-400 mb-6">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3">Fleksibilitas Waktu</h3>
                                <p class="text-gray-400 leading-relaxed">Atur durasi pengerjaan sesuai kebutuhan kurikulum. Peserta dapat mengerjakan kuis dalam rentang waktu yang telah ditentukan.</p>
                            </div>

                            <div class="p-8 rounded-3xl bg-gradient-to-b from-white/5 to-transparent border border-white/10 hover:border-pink-500/50 transition-colors duration-300">
                                <div class="w-14 h-14 bg-pink-500/20 rounded-2xl flex items-center justify-center text-pink-400 mb-6">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-white mb-3">Analisis Skor</h3>
                                <p class="text-gray-400 leading-relaxed">Dapatkan laporan hasil yang akurat. Pantau perkembangan nilai peserta melalui papan peringkat dan riwayat pengerjaan.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="keunggulan" class="py-24 relative">
                    <div class="container mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                            <div>
                                <h2 class="text-3xl font-bold text-white mb-6">Keunggulan Platform SQS</h2>
                                <div class="space-y-8">
                                    <div class="flex gap-4">
                                        <div class="flex-shrink-0 w-12 h-12 bg-indigo-500/10 rounded-xl flex items-center justify-center border border-indigo-500/20 text-indigo-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-white mb-2">Hemat Biaya & Gratis</h4>
                                            <p class="text-gray-400 leading-relaxed">Mulai gunakan platform ini tanpa biaya. Fitur dasar kami memadai untuk kebutuhan kelas dan kelompok belajar.</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-4">
                                        <div class="flex-shrink-0 w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center border border-purple-500/20 text-purple-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-white mb-2">Sangat Interaktif</h4>
                                            <p class="text-gray-400 leading-relaxed">Desain antarmuka yang intuitif memudahkan pengguna dalam navigasi dan pengerjaan soal ujian.</p>
                                        </div>
                                    </div>

                                    <div class="flex gap-4">
                                        <div class="flex-shrink-0 w-12 h-12 bg-pink-500/10 rounded-xl flex items-center justify-center border border-pink-500/20 text-pink-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.416H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-white mb-2">Tanpa Instalasi</h4>
                                            <p class="text-gray-400 leading-relaxed">Berbasis web sepenuhnya. Tidak perlu mengunduh aplikasi tambahan. Cukup gunakan browser Anda.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-3xl blur-2xl opacity-20"></div>
                                <div class="relative bg-gray-800/50 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">
                                    <div class="flex items-center justify-between mb-6 border-b border-white/10 pb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-3 w-3 rounded-full bg-red-500"></div>
                                            <div class="h-3 w-3 rounded-full bg-yellow-500"></div>
                                            <div class="h-3 w-3 rounded-full bg-green-500"></div>
                                        </div>
                                        <span class="text-xs text-gray-500 font-mono">dashboard_preview.blade.php</span>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="h-8 bg-white/5 rounded w-3/4"></div>
                                        <div class="h-4 bg-white/5 rounded w-full"></div>
                                        <div class="h-4 bg-white/5 rounded w-5/6"></div>
                                        <div class="grid grid-cols-2 gap-4 mt-6">
                                            <div class="h-20 bg-indigo-500/20 rounded border border-indigo-500/30"></div>
                                            <div class="h-20 bg-white/5 rounded border border-white/10"></div>
                                            <div class="h-20 bg-white/5 rounded border border-white/10"></div>
                                            <div class="h-20 bg-white/5 rounded border border-white/10"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="populer" class="py-24 bg-black/20">
                    <div class="container mx-auto max-w-7xl px-6 lg:px-8">
                        <div class="flex justify-between items-end mb-12">
                            <div>
                                <h2 class="text-3xl font-bold text-white mb-2">Kuis Populer</h2>
                                <p class="text-gray-400">Kuis yang paling banyak diikuti minggu ini.</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @forelse($popularQuizzes as $quiz)
                                <div class="group bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-6 hover:bg-white/10 hover:-translate-y-2 transition-all duration-300">
                                    <div class="h-40 bg-gradient-to-br from-indigo-900 to-purple-900 rounded-2xl mb-6 relative overflow-hidden group-hover:shadow-lg transition-shadow">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <span class="text-6xl font-black text-white/10 select-none">{{ substr($quiz->title, 0, 1) }}</span>
                                        </div>
                                        <div class="absolute top-3 right-3 bg-black/40 backdrop-blur-sm px-2 py-1 rounded-lg text-xs font-mono text-white border border-white/10">
                                            {{ $quiz->join_code }}
                                        </div>
                                    </div>
                                    
                                    <h3 class="text-lg font-bold text-white mb-2 truncate">{{ $quiz->title }}</h3>
                                    <div class="flex items-center justify-between text-sm text-gray-400 mb-4">
                                        <span>{{ $quiz->user->name }}</span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $quiz->questions->count() }}
                                        </span>
                                    </div>
                                    
                                    <a href="{{ route('quizzes.start', $quiz) }}" class="block w-full py-3 text-center bg-indigo-600/20 border border-indigo-500/30 text-indigo-300 font-semibold rounded-xl hover:bg-indigo-600 hover:text-white transition-all duration-200">
                                        Mulai Kuis
                                    </a>
                                </div>
                            @empty
                                <div class="col-span-4 text-center py-12 bg-white/5 rounded-3xl border border-white/5 border-dashed">
                                    <p class="text-gray-500">Belum ada kuis populer saat ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section id="tentang" class="py-24 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-b from-gray-900 to-indigo-900/20"></div>
                    <div class="container mx-auto max-w-7xl px-6 lg:px-8 relative z-10">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                            <div>
                                <span class="text-indigo-400 font-bold tracking-wider uppercase text-sm">Tentang Kami</span>
                                <h2 class="text-4xl font-bold text-white mt-2 mb-6">Revolusi Sistem Evaluasi</h2>
                                <p class="text-gray-400 text-lg mb-6 leading-relaxed">
                                    SQS (Sistem Quiz Semalam) hadir sebagai solusi manajemen evaluasi pembelajaran. Kami percaya bahwa proses penilaian tidak harus rumit. Dengan sistem yang terintegrasi, kami membantu pengajar menyusun materi berkualitas secara efisien.
                                </p>
                                <p class="text-gray-400 text-lg mb-8 leading-relaxed">
                                    Visi kami adalah menciptakan ekosistem belajar yang kolaboratif, transparan, dan dapat diakses oleh siapa saja, di mana saja.
                                </p>
                                <a href="{{ route('register') }}" class="inline-flex items-center text-white font-bold hover:text-indigo-300 transition-colors">
                                    Bergabung dengan Komunitas
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            </div>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
                                    <h4 class="text-3xl font-bold text-indigo-400 mb-1">100%</h4>
                                    <p class="text-sm text-gray-400">Akses Mudah</p>
                                </div>
                                <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
                                    <h4 class="text-3xl font-bold text-purple-400 mb-1">24/7</h4>
                                    <p class="text-sm text-gray-400">Siap Digunakan</p>
                                </div>
                                <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
                                    <h4 class="text-3xl font-bold text-pink-400 mb-1">Cepat</h4>
                                    <p class="text-sm text-gray-400">Performa Tinggi</p>
                                </div>
                                <div class="bg-white/5 p-6 rounded-2xl border border-white/10">
                                    <h4 class="text-3xl font-bold text-blue-400 mb-1">Aman</h4>
                                    <p class="text-sm text-gray-400">Data Terlindungi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="py-24 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 opacity-20"></div>
                    <div class="container mx-auto max-w-7xl px-6 lg:px-8 relative z-10 text-center">
                        <h2 class="text-4xl font-bold text-white mb-6">Siap Membuat Kuis Pertama Anda?</h2>
                        <p class="text-xl text-indigo-100 mb-10 max-w-2xl mx-auto">Bergabunglah dengan pengajar dan pelajar lainnya untuk pengalaman evaluasi yang lebih baik.</p>
                        <a href="{{ route('register') }}" class="inline-block px-10 py-4 bg-white text-indigo-700 font-bold rounded-2xl shadow-xl hover:shadow-2xl hover:bg-gray-100 hover:scale-105 transition-all duration-300">
                            Buat Akun
                        </a>
                    </div>
                </section>

            </main>

            <footer class="bg-gray-900 border-t border-white/10 pt-16 pb-8">
                <div class="container mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                        <div class="col-span-1 md:col-span-2">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="flex items-center justify-center h-8 w-8 bg-gradient-to-tr from-indigo-500 to-purple-600 rounded-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <span class="text-xl font-bold text-white">SQS</span>
                            </div>
                            <p class="text-gray-400 leading-relaxed max-w-sm">
                                Platform manajemen kuis modern yang dirancang untuk membantu Anda melakukan evaluasi dan pembelajaran secara efektif dan efisien.
                            </p>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-6">Platform</h4>
                            <ul class="space-y-4">
                                <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition-colors">Beranda</a></li>
                                <li><a href="#fitur" class="text-gray-400 hover:text-indigo-400 transition-colors">Fitur</a></li>
                                <li><a href="#keunggulan" class="text-gray-400 hover:text-indigo-400 transition-colors">Keunggulan</a></li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-white font-bold mb-6">Legal</h4>
                            <ul class="space-y-4">
                                <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition-colors">Privasi</a></li>
                                <li><a href="#" class="text-gray-400 hover:text-indigo-400 transition-colors">Syarat & Ketentuan</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                        <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} Sistem Quiz Semalam. All rights reserved.</p>
                        <div class="flex gap-6">
                            <a href="#" class="text-gray-500 hover:text-white transition-colors"><span class="sr-only">Twitter</span><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path></svg></a>
                            <a href="#" class="text-gray-500 hover:text-white transition-colors"><span class="sr-only">GitHub</span><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"></path></svg></a>
                        </div>
                    </div>
                </div>
            </footer>

        </div>

        <script>
            (async () => {
                await tsParticles.load("tsparticles-welcome", {
                    background: {
                        color: { value: "#0f172a" },
                    },
                    fpsLimit: 120,
                    interactivity: {
                        events: {
                            onClick: { enable: true, mode: "push" },
                            onHover: { enable: true, mode: "repulse" },
                            resize: true,
                        },
                        modes: {
                            push: { quantity: 4 },
                            repulse: { distance: 100, duration: 0.4 },
                        },
                    },
                    particles: {
                        color: { value: "#ffffff" },
                        links: {
                            color: "#ffffff",
                            distance: 150,
                            enable: true,
                            opacity: 0.05,
                            width: 1,
                        },
                        move: {
                            direction: "none",
                            enable: true,
                            outModes: { default: "bounce" },
                            random: false,
                            speed: 0.5,
                            straight: false,
                        },
                        number: {
                            density: { enable: true, area: 1000 },
                            value: 80,
                        },
                        opacity: {
                            value: { min: 0.1, max: 0.5 },
                        },
                        shape: {
                            type: "circle",
                        },
                        size: {
                            value: { min: 0.5, max: 1.5 },
                        },
                    },
                    detectRetina: true,
                });
            })();
        </script>
    </body>
</html>