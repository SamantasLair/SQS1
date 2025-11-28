<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Kuis Baru dengan AI
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8">
                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('quizzes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100">
                            <h3 class="text-lg font-bold text-indigo-800 mb-4">1. Informasi Dasar</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="title" value="Judul Kuis" />
                                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="Contoh: Sejarah Indonesia" />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="time_limit" value="Durasi (Menit)" />
                                    <x-text-input id="time_limit" class="block mt-1 w-full" type="number" name="time_limit" :value="old('time_limit', 30)" required />
                                    <x-input-error :messages="$errors->get('time_limit')" class="mt-2" />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="description" value="Deskripsi (Opsional)" />
                                    <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="2">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-purple-50 p-6 rounded-xl border border-purple-100">
                            <h3 class="text-lg font-bold text-purple-800 mb-4">2. Sumber Materi AI</h3>
                            <p class="text-sm text-gray-600 mb-4">Upload PDF atau masukkan teks, AI akan membuatkan soal otomatis.</p>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-input-label for="document" value="Upload File Materi (PDF)" />
                                    <input type="file" name="document" id="document" accept=".pdf" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-purple-100 file:text-purple-700
                                    hover:file:bg-purple-200
                                    mt-1
                                  " />
                                    <p class="text-xs text-gray-500 mt-1">Maksimal 10MB.</p>
                                    <x-input-error :messages="$errors->get('document')" class="mt-2" />
                                </div>

                                <div class="relative flex py-2 items-center">
                                    <div class="flex-grow border-t border-gray-300"></div>
                                    <span class="flex-shrink-0 mx-4 text-gray-400 text-sm">ATAU Manual Text</span>
                                    <div class="flex-grow border-t border-gray-300"></div>
                                </div>

                                <div>
                                    <x-input-label for="topic_text" value="Paste Teks Materi Disini" />
                                    <textarea id="topic_text" name="topic_text" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500" rows="4" placeholder="Paste materi pelajaran di sini jika tidak ada PDF...">{{ old('topic_text') }}</textarea>
                                </div>

                                <div>
                                    <x-input-label for="question_count" value="Jumlah Soal" />
                                    <select id="question_count" name="question_count" class="block mt-1 w-full md:w-1/4 border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                        <option value="5">5 Soal</option>
                                        <option value="10" selected>10 Soal</option>
                                        <option value="15">15 Soal</option>
                                        <option value="20">20 Soal</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end pt-4">
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-lg font-semibold text-white shadow-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                <svg class="w-5 h-5 mr-2 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Generate Kuis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>