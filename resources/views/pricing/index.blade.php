<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Harga Paket - SQS</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/tsparticles-slim@2.0.6/tsparticles.slim.bundle.min.js"></script>
        <style>
            @keyframes shimmer {
                0% { background-position: 200% 0; }
                100% { background-position: -200% 0; }
            }
            .animate-shimmer {
                background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0) 100%);
                background-size: 200% 100%;
                animation: shimmer 3s infinite;
            }
            .gold-text-glow {
                text-shadow: 0 0 10px rgba(234, 179, 8, 0.5);
            }
            .purple-text-glow {
                text-shadow: 0 0 10px rgba(168, 85, 247, 0.5);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#050914] text-gray-100 overflow-x-hidden selection:bg-indigo-500 selection:text-white">
        
        <div id="tsparticles-pricing" class="fixed inset-0 z-0 pointer-events-none"></div>

        <div class="relative z-10 flex flex-col min-h-screen">
            
            <header class="fixed w-full z-50 transition-all duration-300 bg-[#050914]/80 backdrop-blur-xl border-b border-white/5">
                <nav class="container mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <div class="flex items-center gap-3">
                            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                                <div class="flex items-center justify-center h-10 w-10 bg-gradient-to-tr from-indigo-500 to-purple-600 rounded-xl shadow-lg shadow-indigo-500/20 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <span class="text-2xl font-bold text-white tracking-wider">SQS</span>
                            </a>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
                                    Masuk
                                </a>
                            @endauth
                            <a href="{{ url('/') }}" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-sm font-semibold text-white transition-all duration-200 backdrop-blur-sm">
                                Kembali
                            </a>
                        </div>
                    </div>
                </nav>
            </header>

            <main class="flex-grow pt-32 pb-24">
                <div class="container mx-auto max-w-7xl px-6 lg:px-8">
                    
                    <div class="text-center max-w-3xl mx-auto mb-20 relative">
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[300px] bg-indigo-500/10 rounded-full blur-[120px] pointer-events-none"></div>
                        <h2 class="text-4xl md:text-5xl font-black text-white mb-6 tracking-tight relative z-10 leading-tight">
                            Pilih Paket Belajar <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 via-purple-300 to-pink-300">Investasi Masa Depan</span>
                        </h2>
                        <p class="text-lg text-gray-400 relative z-10 max-w-2xl mx-auto font-light leading-relaxed">
                            Semua tipe soal terbuka untuk semua. <br class="hidden md:block">
                            Upgrade untuk membuka kekuatan <span class="text-indigo-400 font-semibold">AI Guru Privat</span> Anda.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 max-w-7xl mx-auto">
                        
                        <div class="group h-full relative">
                            <div class="absolute inset-0 bg-gray-800 rounded-3xl opacity-40 transition-opacity group-hover:opacity-60"></div>
                            <div class="relative h-full flex flex-col p-1 rounded-3xl border border-gray-800 group-hover:border-gray-600 transition-colors duration-300 bg-[#0B1120]">
                                <div class="p-6 flex-1 flex flex-col">
                                    <div class="mb-6">
                                        <h3 class="text-lg font-semibold text-gray-200 mb-2">Basic</h3>
                                        <p class="text-gray-500 text-xs mb-4">Untuk pemula.</p>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-3xl font-bold text-white">Rp 0</span>
                                            <span class="text-gray-500 text-sm font-medium">/bulan</span>
                                        </div>
                                    </div>
                                    
                                    <ul class="space-y-4 mb-8 flex-1">
                                        <li class="flex items-start gap-3 text-sm text-gray-400 group-hover:text-gray-300">
                                            <svg class="w-5 h-5 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span>10 Kuis Penyimpanan</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-gray-400 group-hover:text-gray-300">
                                            <svg class="w-5 h-5 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span>3 Kredit AI / hari</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-gray-400 group-hover:text-gray-300">
                                            <svg class="w-5 h-5 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span>PG & Essay (Bebas)</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-gray-600 opacity-60">
                                            <svg class="w-5 h-5 text-gray-700 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            <span>Analisis AI</span>
                                        </li>
                                    </ul>

                                    <div class="mt-auto">
                                        @if(auth()->check() && (auth()->user()->role === 'user' || auth()->user()->role === null))
                                            <button disabled class="w-full py-3 rounded-xl bg-gray-800/50 text-gray-500 text-sm font-medium border border-gray-800 cursor-default">
                                                Paket Saat Ini
                                            </button>
                                        @elseif(auth()->check())
                                            <button disabled class="w-full py-3 rounded-xl bg-transparent text-gray-600 text-sm font-medium border border-gray-800 cursor-default">
                                                Basic
                                            </button>
                                        @else
                                            <a href="{{ route('register') }}" class="block w-full py-3 rounded-xl bg-gray-800 hover:bg-gray-700 text-white text-center text-sm font-medium transition-all duration-300 border border-gray-700">
                                                Daftar Gratis
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="group h-full relative">
                            <div class="absolute inset-0 bg-blue-900/20 rounded-3xl blur-md opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative h-full flex flex-col p-1 rounded-3xl border border-blue-900/30 group-hover:border-blue-500/50 transition-colors duration-300 bg-[#081028] overflow-hidden">
                                <div class="absolute top-0 right-0 p-4">
                                    <span class="bg-blue-500/10 text-blue-400 text-[10px] font-bold px-2 py-1 rounded border border-blue-500/20">EDUKASI</span>
                                </div>
                                <div class="p-6 flex-1 flex flex-col">
                                    <div class="mb-6">
                                        <h3 class="text-lg font-bold text-blue-100 mb-2">Akademisi</h3>
                                        <p class="text-blue-200/50 text-xs mb-4">Pelajar & Guru.</p>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-3xl font-bold text-white">Gratis</span>
                                            <span class="text-blue-200/50 text-sm font-medium">*Verifikasi</span>
                                        </div>
                                    </div>
                                    
                                    <ul class="space-y-4 mb-8 flex-1">
                                        <li class="flex items-start gap-3 text-sm text-gray-300">
                                            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span>25 Kuis Penyimpanan</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-gray-300">
                                            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span>5 Kredit AI / hari</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-gray-300">
                                            <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            <span>PG & Essay (Bebas)</span>
                                        </li>
                                        <li class="mt-4 pt-4 border-t border-blue-900/30">
                                            <div class="flex items-center gap-3 p-3 rounded-lg bg-blue-900/20 border border-blue-500/20">
                                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                                <span class="text-sm font-semibold text-blue-200">Analisis Diagnostik</span>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="mt-auto">
                                        @if(auth()->check() && auth()->user()->role === 'academic')
                                            <button disabled class="w-full py-3 rounded-xl bg-blue-900/30 text-blue-400 text-sm font-bold border border-blue-900/50 cursor-default">
                                                Paket Saat Ini
                                            </button>
                                        @else
                                            <button class="w-full py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-center text-sm font-bold transition-all shadow-lg shadow-blue-900/20 hover:shadow-blue-600/40">
                                                Ajukan Verifikasi
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="group h-full relative transform hover:-translate-y-2 transition-transform duration-500">
                            <div class="absolute -inset-[1px] bg-gradient-to-b from-indigo-500 to-purple-600 rounded-3xl opacity-50 blur-lg group-hover:opacity-80 transition duration-500"></div>
                            <div class="relative h-full flex flex-col p-[1px] rounded-3xl bg-[#0F0A1F]">
                                <div class="bg-[#0F0A1F] rounded-[23px] h-full flex flex-col p-6 relative overflow-hidden">
                                    <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                                    
                                    <div class="mb-6 mt-2">
                                        <h3 class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 via-purple-300 to-pink-300 mb-2 purple-text-glow">Pro</h3>
                                        <p class="text-indigo-200/60 text-xs mb-4">Bimbel & Kreator.</p>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-4xl font-black text-white">100rb</span>
                                            <span class="text-indigo-200/60 text-sm font-medium">/bulan</span>
                                        </div>
                                    </div>
                                    
                                    <ul class="space-y-4 mb-8 flex-1">
                                        <li class="flex items-start gap-3 text-sm text-gray-200">
                                            <div class="mt-0.5 w-5 h-5 rounded-full bg-indigo-500 flex items-center justify-center text-white flex-shrink-0 text-[10px] font-bold shadow-lg shadow-indigo-500/50">✓</div>
                                            <span>50 Kuis Penyimpanan</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-gray-200">
                                            <div class="mt-0.5 w-5 h-5 rounded-full bg-indigo-500 flex items-center justify-center text-white flex-shrink-0 text-[10px] font-bold shadow-lg shadow-indigo-500/50">✓</div>
                                            <span>50 Kredit AI / hari</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-gray-200">
                                            <div class="mt-0.5 w-5 h-5 rounded-full bg-indigo-500 flex items-center justify-center text-white flex-shrink-0 text-[10px] font-bold shadow-lg shadow-indigo-500/50">✓</div>
                                            <span>PG & Essay (Bebas)</span>
                                        </li>
                                        <li class="mt-4 pt-4 border-t border-indigo-500/30">
                                            <div class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-indigo-900/60 to-purple-900/60 border border-indigo-500/40 relative overflow-hidden group-hover:border-indigo-400/60 transition-colors">
                                                <div class="absolute inset-0 animate-shimmer opacity-20"></div>
                                                <svg class="w-5 h-5 text-purple-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                <span class="text-sm font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-200 to-pink-200 relative z-10">Analisis Remedial & Saran</span>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="mt-auto relative z-10">
                                        @if(auth()->check() && auth()->user()->role === 'pro')
                                            <button disabled class="w-full py-3.5 rounded-xl bg-[#1a142e] text-indigo-400 font-bold border border-indigo-500/30 cursor-default">
                                                Paket Saat Ini
                                            </button>
                                        @else
                                            <a href="{{ auth()->check() ? route('payment.checkout', ['plan' => 'pro']) : route('login') }}" class="block w-full py-3.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-center text-sm font-bold transition-all shadow-lg shadow-indigo-600/40 hover:scale-[1.02]">
                                                Upgrade Pro
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="group h-full relative transform hover:-translate-y-3 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-b from-yellow-600 via-amber-500 to-yellow-700 rounded-3xl opacity-30 blur-xl group-hover:opacity-60 transition duration-700"></div>
                            <div class="relative h-full flex flex-col p-[2px] rounded-3xl bg-gradient-to-b from-yellow-300 via-amber-500 to-yellow-800">
                                <div class="bg-[#120C00] rounded-[22px] h-full flex flex-col p-6 relative overflow-hidden">
                                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#FCD34D 1px, transparent 1px); background-size: 24px 24px;"></div>
                                    <div class="absolute top-0 right-0 p-4">
                                        <svg class="w-8 h-8 text-yellow-500/20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                    </div>

                                    <div class="mb-6 mt-2 relative z-10">
                                        <h3 class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 via-amber-200 to-yellow-400 mb-2 gold-text-glow">Premium</h3>
                                        <p class="text-yellow-500/60 text-xs mb-4">Institusi Besar.</p>
                                        <div class="flex items-baseline gap-1">
                                            <span class="text-4xl font-black text-white drop-shadow-md">250rb</span>
                                            <span class="text-yellow-600 text-sm font-medium">/bulan</span>
                                        </div>
                                    </div>
                                    
                                    <ul class="space-y-4 mb-8 flex-1 relative z-10">
                                        <li class="flex items-start gap-3 text-sm text-yellow-100/90">
                                            <div class="mt-0.5 w-5 h-5 rounded-full bg-gradient-to-br from-yellow-400 to-amber-600 flex items-center justify-center text-[#120C00] flex-shrink-0 text-[10px] font-black shadow-lg shadow-yellow-500/40">✓</div>
                                            <span>Unlimited Kuis</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-yellow-100/90">
                                            <div class="mt-0.5 w-5 h-5 rounded-full bg-gradient-to-br from-yellow-400 to-amber-600 flex items-center justify-center text-[#120C00] flex-shrink-0 text-[10px] font-black shadow-lg shadow-yellow-500/40">✓</div>
                                            <span>Unlimited AI</span>
                                        </li>
                                        <li class="flex items-start gap-3 text-sm text-yellow-100/90">
                                            <div class="mt-0.5 w-5 h-5 rounded-full bg-gradient-to-br from-yellow-400 to-amber-600 flex items-center justify-center text-[#120C00] flex-shrink-0 text-[10px] font-black shadow-lg shadow-yellow-500/40">✓</div>
                                            <span>Prioritas Support</span>
                                        </li>
                                        <li class="mt-4 pt-4 border-t border-yellow-700/30">
                                            <div class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-yellow-900/40 to-amber-900/40 border border-yellow-500/40 relative overflow-hidden group-hover:border-yellow-400/60 transition-colors shadow-[0_0_15px_rgba(234,179,8,0.1)]">
                                                <div class="absolute inset-0 animate-shimmer opacity-30"></div>
                                                <svg class="w-5 h-5 text-yellow-300 relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                                <span class="text-sm font-bold text-transparent bg-clip-text bg-gradient-to-r from-yellow-100 via-amber-100 to-yellow-200 relative z-10">Full Insight & Psikometrik</span>
                                            </div>
                                        </li>
                                    </ul>

                                    <div class="mt-auto relative z-10">
                                        @if(auth()->check() && auth()->user()->role === 'premium')
                                            <button disabled class="w-full py-3.5 rounded-xl bg-[#2a2005] text-yellow-500 font-bold border border-yellow-600/30 cursor-default">
                                                Akun Anda Premium
                                            </button>
                                        @else
                                            <a href="{{ auth()->check() ? route('payment.checkout', ['plan' => 'premium']) : route('login') }}" class="block w-full py-3.5 rounded-xl bg-gradient-to-r from-yellow-500 via-amber-400 to-yellow-600 text-[#120C00] text-center text-sm font-black tracking-wide uppercase transition-all shadow-[0_0_20px_rgba(245,158,11,0.4)] hover:shadow-[0_0_30px_rgba(245,158,11,0.6)] hover:brightness-110 hover:scale-[1.02]">
                                                Jadi Premium
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="mt-24 text-center border-t border-white/5 pt-10">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 text-gray-400 text-xs mb-4">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <span>Pembayaran Aman & Terenkripsi via Midtrans</span>
                        </div>
                        <p class="text-gray-600 text-xs max-w-md mx-auto">
                            Dapat dibatalkan kapan saja. Syarat dan ketentuan berlaku.
                        </p>
                    </div>

                </div>
            </main>

            <footer class="bg-[#050914] border-t border-white/5 py-12">
                <div class="container mx-auto max-w-7xl px-6 lg:px-8 text-center">
                    <p class="text-gray-600 text-sm">&copy; {{ date('Y') }} Sistem Quiz Semalam. All rights reserved.</p>
                </div>
            </footer>
        </div>

        <script>
            (async () => {
                await tsParticles.load("tsparticles-pricing", {
                    background: { color: { value: "transparent" } },
                    fpsLimit: 60,
                    particles: {
                        color: { value: "#ffffff" },
                        links: {
                            color: "#ffffff",
                            distance: 150,
                            enable: true,
                            opacity: 0.03,
                            width: 1,
                        },
                        move: {
                            enable: true,
                            speed: 0.4,
                            direction: "none",
                            random: false,
                            straight: false,
                            outModes: { default: "bounce" },
                        },
                        number: {
                            density: { enable: true, area: 800 },
                            value: 30,
                        },
                        opacity: {
                            value: { min: 0.1, max: 0.4 },
                        },
                        size: {
                            value: { min: 1, max: 2 },
                        },
                    },
                    detectRetina: true,
                });
            })();
        </script>
    </body>
</html>