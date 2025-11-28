<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Quiz Semalam (SQS)</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white">
        
        <div class="flex flex-col min-h-screen">

            <header class="fixed w-full bg-white/90 backdrop-blur-md shadow-sm z-50 transition-all duration-300">
                <nav class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <div class="flex items-center">
                            <a href="#" class="flex-shrink-0 flex items-center justify-center h-10 w-10 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-xl text-white text-xl font-bold shadow-lg transform hover:scale-105 transition duration-300">
                                S
                            </a>
                            <span class="ml-3 text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">SQS</span>
                            
                            <div class="hidden md:flex space-x-8 ml-10">
                                <a href="#" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition">Beranda</a>
                                <a href="#populer" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition">Populer</a>
                                <a href="#fitur" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition">Fitur</a>
                                <a href="#tentang" class="text-sm font-medium text-gray-700 hover:text-indigo-600 transition">Tentang Kami</a>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 rounded-full hover:bg-indigo-700 shadow-md hover:shadow-lg transition duration-300">
                                        Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-600 transition">
                                        Masuk
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-gray-900 rounded-full hover:bg-gray-800 shadow-md hover:shadow-lg transition duration-300">
                                            Daftar Gratis
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </nav>
            </header>

            <main class="flex-grow pt-20">
                
                <section class="relative bg-white overflow-hidden py-20 lg:py-32">
                    <div class="absolute top-0 left-1/2 w-full -translate-x-1/2 h-full z-0 pointer-events-none">
                        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
                        <div class="absolute top-20 right-10 w-72 h-72 bg-indigo-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-2000"></div>
                        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob animation-delay-4000"></div>
                    </div>

                    <div class="container relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 z-10 text-center">
                        <span class="inline-block py-1 px-3 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-wider mb-6">Platform Kuis #1 di Indonesia</span>
                        <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 tracking-tight leading-tight mb-8">
                            Uji Wawasanmu <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Tanpa Batas Waktu</span>
                        </h1>
                        <p class="mt-4 max-w-2xl mx-auto text-xl text-gray-500 mb-10">
                            Buat kuis interaktif, bagikan ke teman, dan tantang mereka untuk mengalahkan skormu. Belajar jadi lebih seru dengan SQS.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-xl shadow-lg hover:shadow-indigo-500/30 hover:-translate-y-1 transition duration-300 w-full sm:w-auto">
                                Mulai Sekarang 🚀
                            </a>
                            <a href="#cara-kerja" class="px-8 py-4 bg-white text-gray-700 font-bold rounded-xl border border-gray-200 hover:bg-gray-50 hover:border-gray-300 transition duration-300 w-full sm:w-auto">
                                Cara Kerja
                            </a>
                        </div>
                    </div>
                </section>

                <section id="populer" class="py-20 bg-gray-50">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-between items-end mb-12">
                            <div>
                                <h2 class="text-3xl font-bold text-gray-900">Kuis Paling Populer 🔥</h2>
                                <p class="mt-2 text-gray-600">Banyak dimainkan minggu ini</p>
                            </div>
                            <a href="{{ route('register') }}" class="hidden md:block text-indigo-600 font-semibold hover:text-indigo-700">Lihat Semua &rarr;</a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            @if(isset($popularQuizzes) && $popularQuizzes->count() > 0)
                                @foreach($popularQuizzes as $quiz)
                                    <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden flex flex-col h-full">
                                        <div class="h-32 bg-gradient-to-r from-gray-100 to-gray-200 relative">
                                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur rounded-lg px-2 py-1 text-xs font-bold text-gray-700 shadow-sm">
                                                {{ $quiz->questions_count ?? 0 }} Soal
                                            </div>
                                        </div>
                                        <div class="p-6 flex-1 flex flex-col">
                                            <div class="mb-4">
                                                <h3 class="text-lg font-bold text-gray-900 line-clamp-1 group-hover:text-indigo-600 transition">{{ $quiz->title }}</h3>
                                                <p class="text-sm text-gray-500 mt-1">by {{ $quiz->user->name }}</p>
                                            </div>
                                            <div class="mt-auto">
                                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                                    <svg class="w-4 h-4 mr-1 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    <span>{{ $quiz->attempts_count }}x dimainkan</span>
                                                </div>
                                                <a href="{{ route('quizzes.start', $quiz) }}" class="block w-full text-center py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl group-hover:bg-indigo-600 transition">
                                                    Mainkan
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-span-4 text-center py-12">
                                    <div class="inline-block p-4 rounded-full bg-gray-100 text-gray-400 mb-3">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <p class="text-gray-500">Belum ada kuis yang tersedia saat ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </section>

                <section id="fitur" class="py-24 bg-white relative overflow-hidden">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
                        <div class="text-center max-w-3xl mx-auto mb-16">
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Fitur Lengkap untuk Pengalaman Terbaik</h2>
                            <p class="text-lg text-gray-600">Kami merancang SQS agar mudah digunakan namun tetap powerful untuk kebutuhan belajar Anda.</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="p-8 rounded-3xl bg-white border border-gray-100 shadow-lg hover:shadow-xl transition duration-300">
                                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Privasi Terjaga</h3>
                                <p class="text-gray-600 leading-relaxed">Data Anda aman bersama kami. Sistem keamanan berlapis menjamin kenyamanan Anda.</p>
                            </div>
                            
                            <div class="p-8 rounded-3xl bg-white border border-gray-100 shadow-lg hover:shadow-xl transition duration-300">
                                <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-6">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Analisis Statistik</h3>
                                <p class="text-gray-600 leading-relaxed">Pantau perkembangan belajarmu dengan grafik statistik yang detail dan mudah dipahami.</p>
                            </div>
                            
                            <div class="p-8 rounded-3xl bg-white border border-gray-100 shadow-lg hover:shadow-xl transition duration-300">
                                <div class="w-14 h-14 bg-pink-100 rounded-2xl flex items-center justify-center text-pink-600 mb-6">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-3">Real-time Leaderboard</h3>
                                <p class="text-gray-600 leading-relaxed">Bersainglah dengan teman-temanmu dan lihat siapa yang menduduki peringkat teratas secara langsung.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="cara-kerja" class="py-24 bg-gray-900 text-white">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                            <div>
                                <h2 class="text-3xl md:text-4xl font-bold mb-6">Mulai dalam Hitungan Detik</h2>
                                <p class="text-gray-400 text-lg mb-8">Tidak perlu instalasi rumit. Cukup buat akun dan Anda siap membuat atau mengerjakan kuis pertama Anda.</p>
                                
                                <div class="space-y-6">
                                    <div class="flex">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-indigo-600 text-white font-bold">1</div>
                                        <div class="ml-4">
                                            <h4 class="text-xl font-bold">Daftar Akun</h4>
                                            <p class="text-gray-400 mt-1">Isi data diri singkat dan verifikasi email Anda.</p>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-gray-700 text-white font-bold">2</div>
                                        <div class="ml-4">
                                            <h4 class="text-xl font-bold">Pilih atau Buat Kuis</h4>
                                            <p class="text-gray-400 mt-1">Cari topik yang Anda suka atau buat tantangan sendiri.</p>
                                        </div>
                                    </div>
                                    <div class="flex">
                                        <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-gray-700 text-white font-bold">3</div>
                                        <div class="ml-4">
                                            <h4 class="text-xl font-bold">Raih Skor Tertinggi</h4>
                                            <p class="text-gray-400 mt-1">Kerjakan sebaik mungkin dan lihat namamu di papan peringkat.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl transform rotate-3 blur-sm opacity-50"></div>
                                <div class="relative bg-gray-800 rounded-3xl p-8 border border-gray-700">
                                    <div class="space-y-4">
                                        <div class="h-4 bg-gray-700 rounded w-3/4"></div>
                                        <div class="h-4 bg-gray-700 rounded w-full"></div>
                                        <div class="h-4 bg-gray-700 rounded w-5/6"></div>
                                        <div class="h-32 bg-gray-700 rounded-xl mt-6 flex items-center justify-center text-gray-500">
                                            Ilustrasi Dashboard
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="tentang" class="py-24 bg-white relative">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                            <div class="relative order-2 lg:order-1">
                                <div class="absolute -top-10 -left-10 w-40 h-40 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                                <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                                    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 aspect-square flex items-center justify-center p-10 text-white text-center">
                                        <div>
                                            <h3 class="text-4xl font-bold mb-2">SQS</h3>
                                            <p class="text-indigo-100">Est. 2025</p>
                                            <div class="mt-8 grid grid-cols-2 gap-4">
                                                <div class="bg-white/10 backdrop-blur rounded-lg p-4">
                                                    <div class="text-2xl font-bold">10k+</div>
                                                    <div class="text-xs opacity-80">Pengguna</div>
                                                </div>
                                                <div class="bg-white/10 backdrop-blur rounded-lg p-4">
                                                    <div class="text-2xl font-bold">500+</div>
                                                    <div class="text-xs opacity-80">Kuis Aktif</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="order-1 lg:order-2">
                                <span class="text-indigo-600 font-bold tracking-wider uppercase text-sm">Tentang Kami</span>
                                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-6">Misi Kami: Membuat Belajar Jadi Menyenangkan</h2>
                                <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                                    Sistem Quiz Semalam (SQS) lahir dari ide sederhana: ujian tidak harus menakutkan. Kami percaya bahwa evaluasi pengetahuan bisa dilakukan dengan cara yang interaktif, fleksibel, dan tanpa tekanan waktu yang kaku.
                                </p>
                                <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                                    Kami adalah tim kecil yang berdedikasi untuk menyediakan platform edukasi gratis yang dapat diakses oleh siapa saja, mulai dari pelajar, mahasiswa, hingga profesional yang ingin mengasah skill mereka.
                                </p>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span class="text-gray-700 font-medium">Akses Selamanya Gratis</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span class="text-gray-700 font-medium">Komunitas Aktif</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span class="text-gray-700 font-medium">Update Fitur Rutin</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span class="text-gray-700 font-medium">Desain User Friendly</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="py-20 bg-indigo-600 relative overflow-hidden">
                    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
                    <div class="container mx-auto max-w-4xl px-4 text-center relative z-10">
                        <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Siap Menguji Pengetahuanmu?</h2>
                        <p class="text-indigo-100 text-xl mb-10">Jangan biarkan malam ini berlalu tanpa ilmu baru. Bergabunglah sekarang juga.</p>
                        <a href="{{ route('register') }}" class="inline-block px-10 py-5 bg-white text-indigo-600 font-bold rounded-full shadow-2xl hover:bg-gray-100 hover:scale-105 transition transform duration-300">
                            Buat Akun Gratis
                        </a>
                    </div>
                </section>

            </main>

            <footer class="bg-gray-50 border-t border-gray-200 pt-16 pb-8">
                <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                        <div class="col-span-1 md:col-span-1">
                            <div class="flex items-center mb-4">
                                <div class="flex items-center justify-center h-8 w-8 bg-indigo-600 rounded-lg text-white font-bold">S</div>
                                <span class="ml-2 text-xl font-bold text-gray-900">SQS</span>
                            </div>
                            <p class="text-gray-500 text-sm leading-relaxed">
                                Sistem Quiz Semalam. Platform belajar interaktif untuk semua.
                            </p>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-900 mb-4">Produk</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li><a href="#fitur" class="hover:text-indigo-600 transition">Fitur</a></li>
                                <li><a href="#populer" class="hover:text-indigo-600 transition">Kuis Populer</a></li>
                                <li><a href="#" class="hover:text-indigo-600 transition">Harga</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-900 mb-4">Perusahaan</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li><a href="#tentang" class="hover:text-indigo-600 transition">Tentang Kami</a></li>
                                <li><a href="#" class="hover:text-indigo-600 transition">Karir</a></li>
                                <li><a href="#" class="hover:text-indigo-600 transition">Blog</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <h4 class="font-bold text-gray-900 mb-4">Legal</h4>
                            <ul class="space-y-2 text-sm text-gray-600">
                                <li><a href="#" class="hover:text-indigo-600 transition">Privasi</a></li>
                                <li><a href="#" class="hover:text-indigo-600 transition">Syarat & Ketentuan</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center">
                        <p class="text-sm text-gray-400">&copy; {{ date('Y') }} Sistem Quiz Semalam. All rights reserved.</p>
                        <div class="flex space-x-6 mt-4 md:mt-0">
                            <a href="#" class="text-gray-400 hover:text-gray-600"><span class="sr-only">Facebook</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg></a>
                            <a href="#" class="text-gray-400 hover:text-gray-600"><span class="sr-only">Twitter</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg></a>
                            <a href="#" class="text-gray-400 hover:text-gray-600"><span class="sr-only">GitHub</span><svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" /></svg></a>
                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </body>
</html>