<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white tracking-tight drop-shadow-md">
            Buat Kuis Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/5 backdrop-blur-xl border border-white/10 overflow-hidden shadow-2xl sm:rounded-2xl p-8">
                
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-500/20 border-l-4 border-red-500 text-red-200 rounded-r-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('quizzes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div>
                        <h3 class="text-xl font-bold text-white border-b border-white/10 pb-4 mb-6 flex items-center gap-2">
                            <span class="bg-indigo-500 w-8 h-8 rounded-lg flex items-center justify-center text-sm shadow">1</span>
                            Informasi Dasar
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-300 mb-2">Judul Kuis</label>
                                <input type="text" name="title" class="w-full bg-black/20 border-gray-600 rounded-xl shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-500 transition" required placeholder="Contoh: Sejarah Indonesia" value="{{ old('title') }}">
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-300 mb-2">Durasi (Menit)</label>
                                <input type="number" name="timer" class="w-full bg-black/20 border-gray-600 rounded-xl shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-500 transition" required value="{{ old('time_limit', 30) }}">
                                <x-input-error :messages="$errors->get('time_limit')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <label class="block font-medium text-sm text-gray-300 mb-2">Deskripsi (Opsional)</label>
                                <textarea name="description" rows="2" class="w-full bg-black/20 border-gray-600 rounded-xl shadow-sm text-white focus:border-indigo-500 focus:ring-indigo-500 placeholder-gray-500 transition">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-900/30 to-purple-900/30 rounded-2xl p-6 border border-indigo-500/20">
                        <div class="flex items-center mb-6">
                            <div class="bg-indigo-600 text-white p-2 rounded-lg mr-3 shadow-lg shadow-indigo-500/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white">Generator Soal Otomatis (AI)</h3>
                                <p class="text-sm text-indigo-200">Isi bagian ini jika ingin soal dibuatkan otomatis. Kosongkan untuk manual.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block font-medium text-sm text-indigo-200 mb-2">Instruksi / Topik / Prompt</label>
                                <textarea name="ai_prompt" rows="3" class="w-full bg-black/20 border-indigo-500/30 rounded-xl shadow-sm text-white focus:border-indigo-400 focus:ring-indigo-400 placeholder-indigo-300/50 transition" placeholder="Contoh: Buatkan soal tentang Perang Dunia II, fokus pada dampak ekonomi.">{{ old('ai_prompt') }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block font-medium text-sm text-indigo-200 mb-2">Upload Materi (PDF)</label>
                                <input type="file" name="document" accept=".pdf" class="block w-full text-sm text-gray-400
                                file:mr-4 file:py-2.5 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-600 file:text-white
                                hover:file:bg-indigo-500
                                cursor-pointer bg-black/20 rounded-xl border border-indigo-500/30
                                " />
                                <p class="text-xs text-indigo-300/70 mt-2 ml-1">*Maksimal 10MB.</p>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-indigo-200 mb-2">Jumlah Soal</label>
                                <select name="question_count" class="w-full bg-black/20 border-indigo-500/30 rounded-xl shadow-sm text-white focus:border-indigo-400 focus:ring-indigo-400">
                                    <option value="5">5 Soal</option>
                                    <option value="10" selected>10 Soal</option>
                                    <option value="15">15 Soal</option>
                                    <option value="20">20 Soal</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-indigo-200 mb-2">Tipe Soal</label>
                                <select name="question_type" class="w-full bg-black/20 border-indigo-500/30 rounded-xl shadow-sm text-white focus:border-indigo-400 focus:ring-indigo-400">
                                    <option value="multiple_choice">Pilihan Ganda</option>
                                    <option value="essay">Essay / Uraian</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 border border-transparent rounded-xl font-bold text-white uppercase tracking-widest hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition ease-in-out duration-150 shadow-lg transform hover:scale-105">
                            Simpan & Buat Kuis
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>