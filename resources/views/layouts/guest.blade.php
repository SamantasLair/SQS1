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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center bg-gray-100">
            <div class="w-full max-w-5xl m-4 sm:m-6 lg:m-8">
                
                <div class="flex bg-white shadow-2xl rounded-lg overflow-hidden h-auto md:h-[40rem]">
                    
                    <div class="hidden md:flex flex-col justify-center items-center w-1/2 bg-gradient-to-b from-blue-500 to-indigo-600 p-12 text-white relative h-full">
                        <div class="absolute top-8 left-8 flex items-center justify-center h-16 w-16 bg-white rounded-full text-indigo-600 text-3xl font-bold">
                            SQS
                        </div>
                        <div class="text-center">
                            <h1 class="text-4xl font-bold mb-3">Sistem Quiz Semalam</h1>
                            <p class="text-lg text-blue-100">Solusi Ujian Tanpa Batas Waktu!</p>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 p-8 sm:p-12 h-full flex flex-col overflow-y-auto">
                        <div class="my-auto">
                            {{ $slot }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>