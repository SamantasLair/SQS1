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
        <script src="https://cdn.jsdelivr.net/npm/tsparticles-slim@2.0.6/tsparticles.slim.bundle.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-900 text-gray-100 overflow-hidden" x-data="{ sidebarOpen: true }">
        
        <div id="tsparticles" class="fixed inset-0 z-0 pointer-events-none"></div>

        <div class="relative z-10 flex h-screen overflow-hidden">
            @include('layouts.navigation')

            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden transition-all duration-300">
                @if (isset($header))
                    <header class="bg-white/10 backdrop-blur-md border-b border-white/10 shadow-lg z-20 sticky top-0">
                        <div class="mx-auto px-6 py-6 sm:px-8 lg:px-10 flex justify-between items-center">
                            {{ $header }}
                            
                            <div class="flex items-center gap-4">
                                <div class="text-right hidden sm:block">
                                    <div class="text-sm font-bold text-white">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-300">{{ Auth::user()->email }}</div>
                                </div>
                                <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 border-2 border-white shadow-lg flex items-center justify-center text-white font-bold text-lg">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            </div>
                        </div>
                    </header>
                @endif

                <main class="flex-1 p-6 sm:p-8 lg:p-10">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script>
            (async () => {
                await tsParticles.load("tsparticles", {
                    background: { color: { value: "#0f172a" } },
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
                        color: { value: ["#6366f1", "#a855f7", "#ec4899", "#3b82f6"] },
                        links: {
                            color: "#ffffff",
                            distance: 150,
                            enable: true,
                            opacity: 0.1,
                            width: 1,
                        },
                        move: {
                            direction: "none",
                            enable: true,
                            outModes: { default: "bounce" },
                            random: false,
                            speed: 1,
                            straight: false,
                        },
                        number: {
                            density: { enable: true, area: 800 },
                            value: 60,
                        },
                        opacity: {
                            value: 0.5,
                        },
                        shape: {
                            type: ["circle", "triangle"],
                        },
                        size: {
                            value: { min: 1, max: 5 },
                        },
                    },
                    detectRetina: true,
                });
            })();
        </script>
    </body>
</html>