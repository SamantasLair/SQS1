<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Kuis Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-8">
                
                <form action="{{ route('quizzes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 border-b pb-2 mb-4">Detail Kuis</h3>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-2">Judul Kuis <span class="text-red-500">*</span></label>
                                <input type="text" name="title" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Contoh: Ujian Tengah Semester Biologi">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-2">Deskripsi (Opsional)</label>
                                <textarea name="description" rows="2" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Deskripsi singkat mengenai kuis ini"></textarea>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700 mb-2">Durasi Pengerjaan (Menit) <span class="text-red-500">*</span></label>
                                <input type="number" name="timer" class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="30" required value="30">
                            </div>
                        </div>
                    </div>

                    <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100">
                        <div class="flex items-center mb-4">
                            <div class="bg-indigo-600 text-white p-2 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-indigo-900">Generator Soal Otomatis (AI)</h3>
                                <p class="text-sm text-indigo-700">Isi bagian ini jika ingin soal dibuatkan otomatis. Kosongkan jika ingin membuat soal manual nanti.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block font-medium text-sm text-indigo-900 mb-2">Instruksi / Topik / Prompt</label>
                                <textarea name="ai_prompt" rows="3" class="w-full border-indigo-200 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-indigo-300" placeholder="Contoh: Buatkan soal tentang Perang Dunia II, fokus pada dampak ekonomi."></textarea>
                                <p class="text-xs text-gray-500 mt-1">*Bisa dikombinasikan dengan file PDF atau berdiri sendiri.</p>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block font-medium text-sm text-indigo-900 mb-2">Upload Materi (PDF)</label>
                                <input type="file" name="document" accept="application/pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-100 file:text-indigo-700 hover:file:bg-indigo-200 cursor-pointer">
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-indigo-900 mb-2">Jumlah Soal</label>
                                <select name="question_count" class="w-full border-indigo-200 rounded-lg focus:ring-indigo-500">
                                    <option value="5">5 Soal</option>
                                    <option value="10" selected>10 Soal</option>
                                    <option value="15">15 Soal</option>
                                    <option value="20">20 Soal</option>
                                </select>
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-indigo-900 mb-2">Tipe Soal</label>
                                <select name="question_type" class="w-full border-indigo-200 rounded-lg focus:ring-indigo-500">
                                    <option value="multiple_choice">Pilihan Ganda</option>
                                    <option value="essay">Essay / Uraian</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg">
                            Simpan & Buat Kuis
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>