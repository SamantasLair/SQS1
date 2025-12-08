<x-app-layout>
    {{-- DEBUG START --}}
    <div class="bg-red-500 text-white p-4 m-4 rounded font-mono text-xs overflow-auto">
        <strong>DEBUG DATA (Hapus ini setelah analisis):</strong>
        @php
            $sampleQuestion = $quiz->questions->first();
        @endphp
        <pre>
1. RAW DB: {{ $sampleQuestion->question_text }}
2. DECODED 1x: {{ html_entity_decode($sampleQuestion->question_text) }}
3. DECODED 2x: {{ html_entity_decode(html_entity_decode($sampleQuestion->question_text)) }}
        </pre>
    </div>
    {{-- DEBUG END --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css">
    
    <style>
        .prose pre {
            background-color: #282c34 !important;
            color: #abb2bf !important;
            padding: 0 !important;
            margin: 0.5em 0 !important;
            border-radius: 0.5rem !important;
            overflow-x: auto;
        }

        .prose pre code {
            background-color: transparent !important;
            color: inherit !important;
            font-family: 'Fira Code', ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
            padding: 0.75rem !important;
            border: none !important;
            display: block !important;
            font-size: 0.875rem !important;
            line-height: 1.5 !important;
        }

        .prose code::before,
        .prose code::after {
            content: "" !important;
            display: none !important;
        }
    </style>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Detail Kuis: {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                <div class="grid grid-cols-2 gap-4 text-sm mb-6">
                    <div>
                        <span class="text-gray-500 block">Pembuat</span>
                        <span class="text-white font-bold">{{ $quiz->user->name ?? 'Unknown' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Dibuat Pada</span>
                        <span class="text-white">{{ $quiz->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-500 block">Deskripsi</span>
                        <p class="text-gray-300 mt-1">{{ $quiz->description ?: '-' }}</p>
                    </div>
                </div>
                
                <h3 class="text-lg font-bold text-white mb-4 border-b border-gray-700 pb-2">Daftar Soal</h3>
                <div class="space-y-4">
                    @foreach($quiz->questions as $index => $q)
                        <div class="bg-gray-900/50 p-4 rounded-lg">
                            <div class="flex gap-3">
                                <span class="text-gray-500 font-bold">#{{ $index + 1 }}</span>
                                <div class="flex-1 min-w-0">
                                    <div class="text-white mb-2 prose prose-invert max-w-none">
                                        {!! html_entity_decode($q->question_text) !!}
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        @foreach($q->options as $opt)
                                            <div class="text-sm px-3 py-2 rounded border {{ $opt->is_correct ? 'border-green-500 bg-green-900/20 text-green-300' : 'border-gray-700 text-gray-400' }}">
                                                <div class="prose prose-invert max-w-none">
                                                    {!! html_entity_decode($opt->option_text) !!}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('admin.quizzes.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">Kembali</a>
                    <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('Hapus kuis ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-500 transition shadow-lg shadow-red-600/20">
                            Hapus Kuis
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/python.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/sql.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            hljs.highlightAll();
        });
    </script>
</x-app-layout>
