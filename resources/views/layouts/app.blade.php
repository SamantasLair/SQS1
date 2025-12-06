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

            body .swal2-popup.system-toast {
                display: flex !important;
                flex-direction: row !important;
                align-items: center !important;
                background: #1e293b !important;
                border-radius: 8px !important;
                padding: 1rem !important;
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5) !important;
                width: auto !important;
                min-width: 300px !important;
                max-width: 450px !important;
            }

            body .swal2-popup.system-toast.toast-success {
                border-left: 4px solid #10b981 !important;
            }

            body .swal2-popup.system-toast.toast-danger {
                border-left: 4px solid #ef4444 !important;
            }

            body .swal2-popup.system-toast .swal2-icon {
                margin: 0 12px 0 0 !important;
                width: 24px !important;
                height: 24px !important;
                border: none !important;
                background: transparent !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }
            
            body .swal2-popup.system-toast.toast-success .swal2-icon-content {
                font-size: 1.25rem !important;
                color: #10b981 !important;
            }

            body .swal2-popup.system-toast.toast-danger .swal2-icon-content {
                font-size: 1.25rem !important;
                color: #ef4444 !important;
            }

            body .swal2-popup.system-toast .swal2-html-container {
                margin: 0 !important;
                padding: 0 !important;
                display: flex !important;
                flex-direction: column !important;
                align-items: flex-start !important;
            }

            .toast-title {
                font-size: 0.9rem;
                font-weight: 600;
                color: #f1f5f9;
                line-height: 1.2;
                margin-bottom: 2px;
            }

            .toast-message {
                font-size: 0.8rem;
                color: #94a3b8;
                line-height: 1.4;
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

            const SystemToast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                },
                showClass: {
                    popup: 'animate__animated animate__slideInRight'
                },
                hideClass: {
                    popup: 'animate__animated animate__slideOutRight'
                }
            });

            function showNotification(title, message, type = 'success') {
                let iconHtml = '';
                let popupClass = 'system-toast';

                if (type === 'danger') {
                    iconHtml = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>';
                    popupClass += ' toast-danger';
                } else {
                    iconHtml = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                    popupClass += ' toast-success';
                }

                SystemToast.fire({
                    html: `
                        <div class="toast-title">${title}</div>
                        <div class="toast-message">${message}</div>
                    `,
                    iconHtml: iconHtml,
                    customClass: {
                        popup: popupClass,
                        icon: 'swal2-icon-content'
                    }
                });
            }

            window.confirmDelete = function(event, formId) {
                event.preventDefault(); 
                event.stopPropagation();
                
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    background: '#1f2937',
                    color: '#f3f4f6',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', 
                    cancelButtonColor: '#374151',
                    confirmButtonText: 'Ya, Hapus',
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
                    showNotification('Data Dihapus', "{{ session('success') }}", 'danger');
                @else
                    showNotification('Berhasil Disimpan', "{{ session('success') }}", 'success');
                @endif
            @endif

            @if(session('error'))
                showNotification('Terjadi Kesalahan', "{{ session('error') }}", 'danger');
            @endif

            @if(session('status'))
                showNotification('Info', "{{ session('status') }}", 'success');
            @endif

        </script>
    </body>
</html>