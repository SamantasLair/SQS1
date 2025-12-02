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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', (event) => {
                hljs.highlightAll();
            });
        </script>
        <style>
            mjx-container, .mjx-chtml, .MathJax_SVG_Display {
                display: inline-block !important;
                margin: 0 0.2em !important;
                vertical-align: middle !important;
                width: auto !important;
            }
            
            mjx-container[display="true"] {
                display: block !important;
                margin: 1em 0 !important;
                text-align: center !important;
            }

            mjx-assistive-mml {
                display: none !important;
            }

            body .swal2-popup.achievement-toast {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                background: linear-gradient(145deg, #1e293b, #0f172a) !important;
                border-left: 4px solid #4ade80 !important;
                border-radius: 4px !important;
                padding: 1rem !important;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5) !important;
                width: 350px !important;
            }

            body .swal2-popup.achievement-toast .swal2-icon {
                margin: 0 12px 0 0 !important;
                width: 40px !important;
                height: 40px !important;
                border: none !important;
                background: rgba(74, 222, 128, 0.2) !important;
                border-radius: 50% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
            
            body .swal2-popup.achievement-toast .swal2-icon .swal2-icon-content {
                font-size: 1.5rem !important;
                color: #4ade80 !important;
                font-weight: bold !important;
            }

            body .swal2-popup.achievement-toast .swal2-html-container {
                margin: 0 !important;
                padding: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: flex-start !important;
            }

            .achievement-title {
                font-size: 0.85rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: #e2e8f0;
                line-height: 1;
                margin-bottom: 4px;
            }

            .achievement-desc {
                font-size: 0.8rem;
                color: #94a3b8;
                line-height: 1.2;
            }
        </style>

        <script>
            window.MathJax = {
                loader: { load: ['[tex]/ams', 'output/svg'] },
                tex: {
                    inlineMath: [['$', '$'], ['\\(', '\\)']],
                    displayMath: [['$$', '$$'], ['\\[', '\\]']],
                    packages: {'[+]': ['ams']},
                    processEscapes: true
                },
                svg: {
                    fontCache: 'global',
                    scale: 1.1,
                    minScale: 1
                },
                startup: {
                    typeset: true
                }
            };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-svg.js" id="MathJax-script" async></script>

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
            (async () => {
                await tsParticles.load("tsparticles", {
                    background: { color: { value: "#0f172a" } },
                    fpsLimit: 60,
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

            const AchievementToast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: false,
                customClass: {
                    popup: 'achievement-toast',
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInRight animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutRight animate__faster'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                    const audio = new Audio('https://cdn.pixabay.com/audio/2021/08/04/audio_0625c153e1.mp3');
                    audio.volume = 0.3;
                    audio.play().catch(e => {});
                }
            });

            function showAchievement(title, message, iconType = 'success') {
                let iconHtml = '🏆';
                if(iconType === 'error') iconHtml = '❌';
                if(iconType === 'info') iconHtml = 'ℹ️';
                if(iconType === 'trash') iconHtml = '🗑️';

                AchievementToast.fire({
                    html: `
                        <div class="achievement-title">${title}</div>
                        <div class="achievement-desc">${message}</div>
                    `,
                    icon: iconType,
                    iconHtml: iconHtml
                });
            }

            window.confirmDelete = function(event, formId) {
                event.preventDefault(); 
                event.stopPropagation();
                
                Swal.fire({
                    title: 'Hapus Kuis?',
                    text: "Tindakan ini akan menghapus data secara permanen!",
                    icon: 'warning',
                    background: '#1f2937',
                    color: '#f3f4f6',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', 
                    cancelButtonColor: '#374151',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    focusCancel: true,
                    backdrop: `rgba(0,0,0,0.7)`
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById(formId);
                        if(form) form.submit();
                    }
                });
            };

            @if(session('success'))
                @if(str_contains(strtolower(session('success')), 'hapus') || str_contains(strtolower(session('success')), 'deleted'))
                    showAchievement('ITEM REMOVED', "{{ session('success') }}", 'trash');
                @else
                    showAchievement('ACHIEVEMENT UNLOCKED', "{{ session('success') }}", 'success');
                @endif
            @endif

            @if(session('error'))
                showAchievement('SYSTEM ERROR', "{{ session('error') }}", 'error');
            @endif

            @if(session('status'))
                showAchievement('NEW NOTIFICATION', "{{ session('status') }}", 'info');
            @endif

        </script>
    </body>
</html>