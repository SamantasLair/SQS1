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
    <body class="font-sans text-gray-100 antialiased bg-gray-900 overflow-hidden">
        
        <div id="tsparticles-guest" class="fixed inset-0 z-0 pointer-events-none"></div>

        <div class="min-h-screen flex flex-col justify-center items-center relative z-10 px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="/" class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-tr from-indigo-500 to-purple-600 rounded-xl shadow-lg shadow-indigo-500/30">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span class="text-3xl font-bold text-white tracking-wider drop-shadow-md">SQS</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl shadow-2xl overflow-hidden p-8 transform hover:scale-[1.01] transition-transform duration-300">
                {{ $slot }}
            </div>
        </div>

        <script>
            (async () => {
                await tsParticles.load("tsparticles-guest", {
                    background: {
                        color: { value: "#0f172a" },
                        image: "linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%)"
                    },
                    fpsLimit: 120,
                    particles: {
                        color: { value: ["#818cf8", "#c084fc", "#e879f9"] },
                        links: {
                            color: "#ffffff",
                            distance: 150,
                            enable: true,
                            opacity: 0.05,
                            width: 1,
                        },
                        move: {
                            direction: "top",
                            enable: true,
                            outModes: { default: "out" },
                            random: true,
                            speed: 0.5,
                            straight: false,
                        },
                        number: {
                            density: { enable: true, area: 800 },
                            value: 40,
                        },
                        opacity: {
                            value: { min: 0.1, max: 0.5 },
                        },
                        shape: {
                            type: "circle",
                        },
                        size: {
                            value: { min: 1, max: 3 },
                        },
                    },
                    detectRetina: true,
                });
            })();
        </script>
    </body>
</html>