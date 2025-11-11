<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistem Quiz Semalam (SQS)</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white">
        
        <div class="flex flex-col min-h-screen">

            <header class="sticky top-0 bg-white shadow-sm z-50">
                <nav class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 bg-indigo-600 rounded-full text-white text-xl font-bold">
                                SQS
                            </div>
                            <div class="hidden md:flex space-x-8 ml-10">
                                <a href="#" class="font-medium text-gray-900 hover:text-indigo-600">Home</a>
                                <a href="#fitur" class="font-medium text-gray-500 hover:text-indigo-600">Fitur</a>
                                <a href="#tentang" class="font-medium text-gray-500 hover:text-indigo-600">Tentang Kami</a>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="relative hidden md:block">
                                <input type="text" placeholder="Cari kuis..." class="block w-full pl-4 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            @if (Route::has('login'))
                                @auth
                                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                                        <x-dropdown align="right" width="48">
                                            <x-slot name="trigger">
                                                <button class="flex items-center justify-center h-10 w-10 bg-indigo-600 rounded-full text-white text-xl font-bold focus:outline-none transition ease-in-out duration-150">
                                                    <div>{{ substr(Auth::user()->name, 0, 1) }}</div>
                                                </button>
                                            </x-slot>
            
                                            <x-slot name="content">
                                                <div class="px-4 py-2 border-b border-gray-200">
                                                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                                                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                                                </div>
                                                <x-dropdown-link :href="route('dashboard')">
                                                    {{ __('Dashboard') }}
                                                </x-dropdown-link>
                                                <x-dropdown-link :href="route('profile.edit')">
                                                    Edit Data Diri
                                                </x-dropdown-link>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <x-dropdown-link :href="route('logout')"
                                                            onclick="event.preventDefault();
                                                                        this.closest('form').submit();">
                                                        {{ __('Log Out') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-gray-200">
                                        Masuk
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                            Daftar
                                        </a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </nav>
            </header>

            <main class="flex-grow">
                <section class="bg-white py-16 sm:py-24">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                            <div>
                                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                                    Selamat Datang di <br>
                                    Sistem <span class="text-indigo-600">Quiz</span> Semalam
                                </h1>
                                <p class="mt-6 text-lg text-gray-600">
                                    Solusi ujian tanpa batas waktu! Buat, bagikan, dan kerjakan kuis dengan mudah dan interaktif.
                                </p>
                                <div class="mt-10">
                                    <a href="{{ route('register') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-lg shadow-md hover:from-blue-600 hover:to-indigo-700">
                                        Mulai Sekarang
                                    </a>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <div class="bg-gray-200 h-80 rounded-lg flex items-center justify-center text-gray-500">
                                    [Placeholder untuk Ilustrasi Hero]
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="populer" class="bg-gray-50 py-16 sm:py-24">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Kuis Populer</h2>
                        <div class="flex overflow-x-auto space-x-6 pb-4">
                            @forelse($popularQuizzes as $quiz)
                                <div class="flex-shrink-0 w-72 bg-white rounded-lg shadow-lg overflow-hidden">
                                    <div class="p-4 flex flex-col justify-between h-full">
                                        <div>
                                            <div class="bg-indigo-500 h-32 rounded-lg mb-4"></div>
                                            <p class="text-sm text-gray-600">oleh {{ $quiz->user->name }}</p>
                                            <p class="text-sm text-gray-500 mt-1">{{ $quiz->questions->count() }} Pertanyaan</p>
                                            <h3 class="text-lg font-semibold text-gray-900 truncate mt-2">{{ $quiz->title }}</h3>
                                        </div>
                                        <a href="{{ route('quizzes.start', $quiz) }}" class="mt-4 block w-full text-center px-4 py-2 bg-indigo-100 text-indigo-700 font-semibold rounded-lg text-sm hover:bg-indigo-200">
                                            Mulai Kuis
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-600 text-center w-full">Belum ada kuis populer.</p>
                            @endforelse
                        </div>
                    </div>
                </section>

                <section id="fitur" class="bg-white py-16 sm:py-24">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="text-center mb-12">
                            <h2 class="text-3xl font-bold text-gray-900">Mengapa memilih SQS?</h2>
                            <p class="mt-4 text-lg text-gray-600">SQS adalah platform kuis online yang inovatif, mudah digunakan, dan dapat diakses kapanpun dan dimanapun Anda berada.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            
                            <div class="bg-blue-50 p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 text-blue-600 mb-4">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 1.944A11.954 11.954 0 012.166 5.002L2 14.833A11.95 11.95 0 0110 18.056a11.95 11.95 0 018-3.223V5.002A11.954 11.954 0 0110 1.944zM8.75 10.19l-1.955 1.955a.75.75 0 01-1.06-1.06l2.5-2.5a.75.75 0 011.06 0l4.5 4.5a.75.75 0 01-1.06 1.06L8.75 10.19z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900">Aman dan Terpercaya</h3>
                                <p class="mt-2 text-gray-600">Sistem kuis kami dibuat dengan teknologi terbaru yang menjamin keamanan data dan privasi Anda.</p>
                            </div>
                            
                            <div class="bg-orange-50 p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 text-orange-600 mb-4">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z" />
                                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900">Analisis Mendalam</h3>
                                <p class="mt-2 text-gray-600">SQS dilengkapi dengan fitur analisis data yang membantu Anda memahami kinerja peserta kuis.</p>
                            </div>
                            
                            <div class="bg-purple-50 p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-purple-100 text-purple-600 mb-4">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 2a.75.75 0 01.75.75v.518l.968.484a.75.75 0 01.474.999l-.364 1.182a.75.75 0 01-1.32.41l-.924-2.31a.75.75 0 010-.694l.924-2.31a.75.75 0 011.32.41l.364 1.182a.75.75 0 01-.474.999l-.968.484v.518A.75.75 0 0110 2z" />
                                        <path fill-rule="evenodd" d="M4 4.75A.75.75 0 014.75 4h10.5a.75.75 0 010 1.5H4.75A.75.75 0 014 4.75zM8.07 8.243a.75.75 0 011.06 0l1.94 1.94a.75.75 0 01-1.06 1.06L8.07 9.303a.75.75 0 010-1.06zm-3.53 2.47a.75.75 0 010 1.06l-1.94 1.94a.75.75 0 11-1.06-1.06L4.54 10.71a.75.75 0 010-1.06zm7.06 0a.75.75 0 011.06 0l1.94 1.94a.75.75 0 11-1.06 1.06L11.59 10.71a.75.75 0 010-1.06zM3 16.75A.75.75 0 013.75 16h12.5a.75.75 0 010 1.5H3.75A.75.75 0 013 16.75z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900">Leaderboard</h3>
                                <p class="mt-2 text-gray-600">Fitur leaderboard dapat memotivasi peserta kuis untuk bersaing secara sehat.</p>
                            </div>

                            <div class="bg-green-50 p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-green-100 text-green-600 mb-4">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 2.5c-4.142 0-7.5 3.358-7.5 7.5s3.358 7.5 7.5 7.5 7.5-3.358 7.5-7.5-3.358-7.5-7.5-7.5zm.707 10.207a.75.75 0 00-1.414 0L9 11.06v1.19a.75.75 0 001.5 0v-1.19l.207 1.654a.75.75 0 001.414 0l-1.914-5.006a.75.75 0 00-1.414 0L7.086 12.75H5.75a.75.75 0 000 1.5h1.69l.207-1.654a.75.75 0 00-1.414 0L5.75 14.25h-1.5a.75.75 0 000 1.5h1.5a.75.75 0 00.67-1.162l1.914-5.006a.75.75 0 00.18-.328V7.5a.75.75 0 00-1.5 0v.086L4.08 12.603a.75.75 0 00.67 1.162h1.5l.478-3.824a.75.75 0 00-1.414 0L4.81 13.77a.75.75 0 00-.67 1.162h.154a.75.75 0 00.67-1.162l.981-2.58a.75.75 0 00.18-.328V9.75a.75.75 0 00-1.5 0v.086L3.08 14.853a.75.75 0 00.67 1.162h1.5a.75.75 0 00.67-1.162L7.333 10H8.75a.75.75 0 00.67-1.162L7.506 3.832a.75.75 0 00-1.414 0L5.25 6.086a.75.75 0 001.414 0L7.158 5h.08a.75.75 0 00.67-1.162L6.08 3.832a.75.75 0 00-1.414 0L3.82 8.838a.75.75 0 00.67 1.162H6.25a.75.75 0 00.67-1.162l-.022-.176a.75.75 0 00-1.414 0l-.022.176A.75.75 0 004.81 8.838H3.08a.75.75 0 00-.67 1.162l1.654 4.33a.75.75 0 00.67 1.162h1.5a.75.75 0 00.67-1.162L5.58 12.75h1.668l.478 3.824a.75.75 0 001.414 0l.478-3.824h1.667l-1.414 3.704a.75.75 0 00.67 1.162h1.5a.75.75 0 00.67-1.162l1.654-4.33a.75.75 0 00-.67-1.162h-1.73a.75.75 0 00-.67 1.162l-.022.176a.75.75 0 00-1.414 0l-.022-.176a.75.75 0 00-.67-1.162H11.25a.75.75 0 00-.67 1.162l-.022.176a.75.75 0 00-1.414 0l-.022-.176a.75.75 0 00-.67-1.162h-1.69a.75.75 0 00-.67 1.162l1.654 4.33a.75.75 0 00.67 1.162h1.5a.75.75 0 00.67-1.162L14.418 10H16.25a.75.75 0 000-1.5h-1.69l-.207 1.654a.75.75 0 001.414 0L16.25 8.5h1.5a.75.75 0 000-1.5h-1.5a.75.75 0 00-.67 1.162l-1.914 5.006a.75.75 0 00.18.328V12.5a.75.75 0 00-1.5 0v.086L10.92 7.58a.75.75 0 00-.67-1.162h-1.5a.75.75 0 00-.67 1.162l-.022.176a.75.75 0 00-1.414 0l-.022-.176A.75.75 0 006.94 7.58H5.21a.75.75 0 00-.67 1.162l1.654 4.33a.75.75 0 00.67 1.162h1.5a.75.75 0 00.67-1.162L7.333 10H8.75a.75.75 0 00.67-1.162L7.506 3.832a.75.75 0 00-1.414 0L5.25 6.086a.75.75 0 001.414 0L7.158 5h.08a.75.75 0 00.67-1.162L6.08 3.832a.75.75 0 00-1.414 0L3.82 8.838a.75.75 0 00.67 1.162H6.25a.75.75 0 00.67-1.162l-.022-.176a.75.75 0 00-1.414 0l-.022.176A.75.75 0 004.81 8.838H3.08a.75.75 0 00-.67 1.162l1.654 4.33a.75.75 0 00.67 1.162h1.5a.75.75 0 00.67-1.162L5.58 12.75h1.668l.478 3.824a.75.75 0 001.414 0l.478-3.824h1.667l-1.414 3.704a.75.75 0 00.67 1.162h1.5a.75.75 0 00.67-1.162l1.654-4.33a.75.75 0 00-.67-1.162h-1.73a.75.75 0 00-.67 1.162l-.022.176a.75.75 0 00-1.414 0l-.022-.176a.75.75 0 00-.67-1.162H11.25a.75.75 0 00-.67 1.162l-.022.176a.75.75 0 00-1.414 0l-.022-.176a.75.75 0 00-.67-1.162h-1.69a.75.75 0 00-.67 1.162l1.654 4.33a.75.75 0 00.67 1.162h1.5a.75.75 0 00.67-1.162L14.418 10H16.25a.75.75 0 000-1.5h-1.69l-.207 1.654a.75.75 0 001.414 0L16.25 8.5h1.5a.75.75 0 000-1.5h-1.5a.75.75 0 00-.67 1.162l-1.914 5.006a.75.75 0 00.18.328V12.5a.75.75 0 00-1.5 0v.086L10.92 7.58a.75.75 0 00-.67-1.162h-1.5a.75.75 0 00-.67 1.162l-.022.176a.75.75 0 00-1.414 0l-.022-.176A.75.75 0 006.94 7.58H5.21a.75.75 0 00-.67 1.162l1.654 4.33a.75.75 0 00.67 1.162h1.5a.75.75 0 00.67-1.162L7.333 10H8.75a.75.75 0 00.67-1.162L7.506 3.832a.75.75 0 00-1.414 0L5.25 6.086a.75.75 0 001.414 0L7.158 5h.08a.75.75 0 00.67-1.162L6.08 3.832a.75.75 0 00-1.414 0L3.82 8.838a.75.75 0 00.67 1.162H6.25a.75.75 0 00.67-1.162l-.022-.176a.75.75 0 00-1.414 0l-.022.176A.75.75 0 004.81 8.838H3.08a.75.75 0 00-.67 1.162l1.654 4.33a.75.75 0 00.67 1.162h1.5a.75.75 0 00.67-1.162L5.58 12.75h1.668l.478 3.824a.75.75 0 001.414 0l.478-3.824h1.667l-1.414 3.704a.75.75 0 00.67 1.162h1.5a.75.75 0 00.67-1.162l1.654-4.33a.75.75 0 00-.67-1.162h-1.73a.75.75 0 00-.67 1.162l-.022.176a.75.75 0 00-1.414 0l-.022-.176a.75.75 0 00-.67-1.162H11.25a.75.75 0 00-.67 1.162l-.022.176a.75.75 0 00-1.414 0l-.022-.176a.75.75 0 00-.67-1.162h-1.69z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900">Akses Fleksibel</h3>
                                <p class="mt-2 text-gray-600">SQS dapat diakses kapanpun dan dimanapun Anda berada.</p>
                            </div>

                            <div class="bg-red-50 p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-red-100 text-red-600 mb-4">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900">Tanpa Batas Waktu</h3>
                                <p class="mt-2 text-gray-600">Peserta kuis dapat mengerjakan kuis kapanpun tanpa batasan waktu.</p>
                            </div>

                            <div class="bg-teal-50 p-6 rounded-lg shadow-lg">
                                <div class="flex items-center justify-center h-12 w-12 rounded-full bg-teal-100 text-teal-600 mb-4">
                                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13 4.5a2.5 2.5 0 11.702 4.283l-0.12.12-.12.12-2.494 2.493a.75.75 0 01-1.06 0l-.12-.12-.12-.121a2.5 2.5 0 114.283-.702l.12-.12.12-.12a.75.75 0 011.06 0l2.494 2.494.12.12.12.12a2.5 2.5 0 11-.702 4.283l-.12-.12-.12-.12-2.493-2.494a.75.75 0 010-1.06l.12-.12.12-.12a2.5 2.5 0 11-.702-4.283l.12.12.12.12L13 8.682l.12-.12.12-.121a2.5 2.5 0 01-.702-4.283z" />
                                        <path d="M7 15.5a2.5 2.5 0 11-.702-4.283l.12-.12.12-.12 2.493-2.494a.75.75 0 011.06 0l.12.12.12.121a2.5 2.5 0 11-4.283.702l-.12.12-.12.12a.75.75 0 01-1.06 0l-2.494-2.494-.12-.12-.12-.12a2.5 2.5 0 11.702-4.283l.12.12.12.12L7 7.318l-.12.12-.12.121a2.5 2.5 0 01.702 4.283l-.12-.12-.12-.12L5.818 10 5.698 9.88l-.12-.12a2.5 2.5 0 11.702-4.283z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900">Berbagi Kuis</h3>
                                <p class="mt-2 text-gray-600">Anda dapat dengan mudah membagikan kuis yang telah Anda buat kepada siapa saja.</p>
                            </div>

                        </div>
                    </div>
                </section>

                <section id="cara-kerja" class="bg-gray-50 py-16 sm:py-24">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="text-center mb-12">
                            <h2 class="text-3xl font-bold text-gray-900">Bagaimana Cara SQS Bekerja?</h2>
                            <p class="mt-4 text-lg text-gray-600">Berikut adalah langkah-langkah yang dapat Anda ikuti untuk memulai SQS.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            
                            <div class="text-center p-6">
                                <div class="relative w-20 h-20 mx-auto mb-4">
                                    <div class="absolute inset-0 bg-blue-100 rounded-full"></div>
                                    <div class="absolute inset-2 bg-blue-200 rounded-full flex items-center justify-center">
                                        <span class="text-3xl font-bold text-blue-600">01</span>
                                    </div>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Buat Kuis</h4>
                                <p class="mt-1 text-gray-600">Pengguna dapat membuat kuis baru dengan menambahkan pertanyaan dan pilihan jawaban.</p>
                            </div>
                            
                            <div class="text-center p-6">
                                <div class="relative w-20 h-20 mx-auto mb-4">
                                    <div class="absolute inset-0 bg-orange-100 rounded-full"></div>
                                    <div class="absolute inset-2 bg-orange-200 rounded-full flex items-center justify-center">
                                        <span class="text-3xl font-bold text-orange-600">02</span>
                                    </div>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Bagikan Kode</h4>
                                <p class="mt-1 text-gray-600">Setiap kuis yang dibuat akan memiliki kode unik yang dapat dibagikan kepada peserta.</p>
                            </div>
                            
                            <div class="text-center p-6">
                                <div class="relative w-20 h-20 mx-auto mb-4">
                                    <div class="absolute inset-0 bg-purple-100 rounded-full"></div>
                                    <div class="absolute inset-2 bg-purple-200 rounded-full flex items-center justify-center">
                                        <span class="text-3xl font-bold text-purple-600">03</span>
                                    </div>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Kerjakan Kuis</h4>
                                <p class="mt-1 text-gray-600">Peserta dapat memasukkan kode kuis untuk mulai mengerjakan kuis kapanpun.</p>
                            </div>

                            <div class="text-center p-6">
                                <div class="relative w-20 h-20 mx-auto mb-4">
                                    <div class="absolute inset-0 bg-green-100 rounded-full"></div>
                                    <div class="absolute inset-2 bg-green-200 rounded-full flex items-center justify-center">
                                        <span class="text-3xl font-bold text-green-600">04</span>
                                    </div>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900">Lihat Hasil</h4>
                                <p class="mt-1 text-gray-600">Setelah selesai, peserta dapat melihat skor dan peringkat mereka di leaderboard.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="bg-indigo-600">
                    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 text-center">
                        <h2 class="text-3xl font-bold text-white">Mulai Petualangan Kuis Anda!</h2>
                        <p class="mt-4 text-lg text-indigo-100">Bergabunglah dengan ribuan pengguna lain dan buat kuis pertama Anda hari ini.</p>
                        <a href="{{ route('register') }}" class="mt-8 inline-block px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg shadow-md hover:bg-gray-100">
                            Daftar Sekarang
                        </a>
                    </div>
                </section>
            </main>

            <footer class="bg-gray-900 text-gray-400 py-12">
                <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div>
                            <div class="flex items-center justify-center h-10 w-10 bg-indigo-600 rounded-full text-white text-xl font-bold">
                                SQS
                            </div>
                            <p class="mt-4 text-sm">Sistem Quiz Semalam. Solusi ujian tanpa batas waktu.</p>
                        </div>
                        <div>
                            <h5 class="font-semibold text-white uppercase">Tautan</h5>
                            <ul class="mt-4 space-y-2">
                                <li><a href="#fitur" class="hover:text-white">Fitur</a></li>
                                <li><a href="#tentang" class="hover:text-white">Tentang Kami</a></li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="font-semibold text-white uppercase">Legal</h5>
                            <ul class="mt-4 space-y-2">
                                <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                                <li><a href="#" class="hover:text-white">Terms of Service</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-8 border-t border-gray-800 pt-8 text-center text-sm">
                        &copy; {{ date('Y') }} Sistem Quiz Semalam. All rights reserved.
                    </div>
                </div>
            </footer>

        </div>
    </body>
</html>