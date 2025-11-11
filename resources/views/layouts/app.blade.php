<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="h-screen flex bg-gray-100">
            
            <aside class="w-64 flex-shrink-0 bg-gradient-to-b from-indigo-600 to-purple-700 text-white flex flex-col">
                <div class="h-20 flex items-center justify-center bg-white bg-opacity-10">
                    <div class="flex items-center justify-center h-12 w-12 bg-white rounded-full text-indigo-600 text-2xl font-bold">
                        SQS
                    </div>
                </div>
                
                <nav class="flex-grow px-4 py-6 space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition-colors">
                        <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M10 3.75a2 2 0 100 4 2 2 0 000-4zM10 8.75a2 2 0 100 4 2 2 0 000-4zM10 13.75a2 2 0 100 4 2 2 0 000-4z" /></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('quizzes.index') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('quizzes.*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition-colors">
                        <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M3.5 3.75a.25.25 0 01.25-.25h12.5a.25.25 0 01.25.25v12.5a.25.25 0 01-.25.25H3.75a.25.25 0 01-.25-.25V3.75zM5 6.25v1.5h10v-1.5H5zm0 3v1.5h10v-1.5H5zm0 3v1.5h10v-1.5H5z" /></svg>
                        Kuis Saya
                    </a>
                    <a href="{{ route('quizzes.join.show') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('quizzes.join.*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition-colors">
                        <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 3a.75.75 0 01.75.75v1.5h1.5a.75.75 0 010 1.5h-1.5v1.5a.75.75 0 01-1.5 0v-1.5h-1.5a.75.75 0 010-1.5h1.5v-1.5A.75.75 0 0110 3zM8.05 9.95a.75.75 0 011.06 0l3 3a.75.75 0 01-1.06 1.06l-3-3a.75.75 0 010-1.06zM9.95 11.95a.75.75 0 010 1.06l-3 3a.75.75 0 01-1.06-1.06l3-3a.75.75 0 011.06 0zM11.06 9.95a.75.75 0 011.06 0l3 3a.75.75 0 11-1.06 1.06l-3-3a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
                        Gabung Kuis
                    </a>
                    
                    @if(Auth::user()->role === 'admin')
                    <hr class="border-white border-opacity-20 my-4">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.*') ? 'bg-white bg-opacity-20' : 'hover:bg-white hover:bg-opacity-10' }} transition-colors">
                        <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9.69 1.646a.75.75 0 01.62 0l6.25 3.124a.75.75 0 01.44 1.02l-1.875 5.624a.75.75 0 01-1.18.44l-2.375-1.999a.75.75 0 00-.96 0l-2.375 1.999a.75.75 0 01-1.18-.44L3.19 5.79a.75.75 0 01.44-1.02l6.25-3.124zM10 14.882L12.868 12.5l1.563 4.688a.75.75 0 01-1.18.44l-2.375-1.999a.75.75 0 00-.96 0l-2.375 1.999a.75.75 0 01-1.18-.44L7.132 12.5 10 14.882z" clip-rule="evenodd" /></svg>
                        Admin Panel
                    </a>
                    @endif
                </nav>
                
                <div class="p-4 border-t border-white border-opacity-20">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-white bg-opacity-30 flex items-center justify-center font-semibold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3 min-w-0">
                            <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-indigo-100 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="w-full flex items-center justify-center px-4 py-2 rounded-lg text-sm hover:bg-white hover:bg-opacity-10 transition-colors">
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2A.75.75 0 0010.75 3.5h-5.5A.75.75 0 004.5 4.25v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25zM10.75 8.75a.75.75 0 000 1.5h3.56l-1.03 1.03a.75.75 0 001.06 1.06l2.5-2.5a.75.75 0 000-1.06l-2.5-2.5a.75.75 0 10-1.06 1.06l1.03 1.03H10.75z" clip-rule="evenodd" /></svg>
                            Log Out
                        </a>
                    </form>
                </div>
            </aside>

            <div class="flex-1 flex flex-col overflow-hidden">
                <header class="bg-white shadow-sm border-b border-gray-200">
                    <div class="px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>

                <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>