<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script src="https://cdn.jsdelivr.net/npm/tsparticles-slim@2.0.6/tsparticles.slim.bundle.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-900 text-gray-100 overflow-hidden" x-data="{ sidebarOpen: true }">
        
        <div id="tsparticles" class="fixed inset-0 z-0 pointer-events-none"></div>

        <div class="relative z-10 flex h-screen overflow-hidden">
            
            @include('layouts.navigation')

            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden transition-all duration-300">
                
                @if (isset($header))
                    <header class="bg-gray-800/80 backdrop-blur-md border-b border-gray-700 shadow-lg sticky top-0 z-20">
                        <div class="mx-auto px-6 py-4 sm:px-8 lg:px-10">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <main class="flex-1 p-6 sm:p-8 lg:p-10">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

        <script>
            // 1. Konfigurasi Background Particles
            (async () => {
                await tsParticles.load("tsparticles", {
                    background: { color: { value: "#0f172a" } }, // Sesuai bg-gray-900
                    fpsLimit: 60,
                    particles: {
                        color: { value: ["#6366f1", "#a855f7", "#ec4899"] },
                        links: { color: "#ffffff", distance: 150, enable: true, opacity: 0.05, width: 1 },
                        move: { enable: true, speed: 0.5 },
                        number: { density: { enable: true, area: 800 }, value: 60 },
                        opacity: { value: 0.3 },
                        size: { value: { min: 1, max: 3 } },
                    },
                    detectRetina: true,
                });
            })();

            // 2. Konfigurasi SweetAlert2 (Pop Up)
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#1f2937', // gray-800
                color: '#fff',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Override window.alert biasa
            window.alert = function(message) {
                Swal.fire({
                    title: 'Informasi',
                    text: message,
                    icon: 'info',
                    background: '#1f2937',
                    color: '#fff',
                    confirmButtonColor: '#4f46e5',
                    confirmButtonText: 'Oke'
                });
            };

            // Fungsi Global Konfirmasi (Dipakai di Edit Kuis & Attempt Kuis)
            window.confirmAction = function(event, formId, title = 'Apakah Anda yakin?', text = 'Tindakan ini tidak dapat dibatalkan!', confirmText = 'Ya, Lanjutkan') {
                event.preventDefault();
                Swal.fire({
                    title: title,
                    text: text,
                    icon: 'warning',
                    background: '#1f2937',
                    color: '#fff',
                    showCancelButton: true,
                    confirmButtonColor: '#4f46e5',
                    cancelButtonColor: '#374151',
                    confirmButtonText: confirmText,
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    }
                });
            }

            // Notifikasi Session Laravel
            @if(session('success'))
                Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
            @endif

            @if(session('error'))
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Oops...', 
                    text: "{{ session('error') }}", 
                    background: '#1f2937', 
                    color: '#fff', 
                    confirmButtonColor: '#4f46e5' 
                });
            @endif
        </script>
    </body>
</html>