<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Kuis & Soal') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="quizForm()">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('quizzes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900 border-b border-gray-100">
                        <h3 class="text-lg font-medium text-indigo-600 mb-4">1. Informasi Umum Kuis</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <x-input-label for="title" :value="__('Judul Kuis')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full text-lg" :value="old('title')" required placeholder="Contoh: Ujian Matematika Dasar" />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>

                            <div>
                                <x-input-label for="description" :value="__('Deskripsi')" />
                                <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Deskripsi singkat mengenai kuis ini...">{{ old('description') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('description')" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <template x-for="(question, qIndex) in questions" :key="question.id">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg relative border-l-4 border-indigo-500">
                            <div class="p-6 text-gray-900">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-md font-bold text-gray-700" x-text="'Soal No. ' + (qIndex + 1)"></h3>
                                    <button type="button" @click="removeQuestion(qIndex)" class="text-red-500 hover:text-red-700 text-sm font-semibold" x-show="questions.length > 1">
                                        &times; Hapus Soal
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="md:col-span-2 space-y-4">
                                        <div>
                                            <x-input-label :value="__('Pertanyaan')" />
                                            <textarea 
                                                :name="'questions[' + qIndex + '][question_text]'" 
                                                rows="3" 
                                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                                required 
                                                placeholder="Tulis pertanyaan di sini..."></textarea>
                                        </div>

                                        <div>
                                            <x-input-label :value="__('Gambar (Opsional)')" />
                                            <input type="file" :name="'questions[' + qIndex + '][image]'" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
                                        </div>
                                    </div>

                                    <div class="md:col-span-1 bg-gray-50 p-4 rounded-lg h-fit">
                                        <x-input-label :value="__('Tipe Soal')" class="mb-2" />
                                        <select 
                                            :name="'questions[' + qIndex + '][question_type]'" 
                                            x-model="question.type" 
                                            class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="multiple_choice">Pilihan Ganda</option>
                                            <option value="essay">Essai / Isian</option>
                                        </select>
                                        
                                        <p class="text-xs text-gray-500 mt-2" x-show="question.type === 'essay'">
                                            Peserta akan menjawab dengan teks bebas. Penilaian dilakukan manual atau berdasarkan kata kunci (future update).
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-6 border-t pt-4" x-show="question.type === 'multiple_choice'">
                                    <label class="block font-medium text-sm text-gray-700 mb-2">Pilihan Jawaban & Kunci Jawaban</label>
                                    <div class="space-y-3">
                                        <template x-for="(option, oIndex) in question.options" :key="oIndex">
                                            <div class="flex items-center gap-3">
                                                <input type="radio" 
                                                    :name="'questions[' + qIndex + '][correct_option_index]'" 
                                                    :value="oIndex" 
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" 
                                                    required 
                                                    title="Tandai sebagai jawaban benar">
                                                
                                                <x-text-input 
                                                    :name="'questions[' + qIndex + '][options][' + oIndex + '][option_text]'" 
                                                    type="text" 
                                                    class="block w-full" 
                                                    placeholder="Teks Pilihan" 
                                                    required />
                                                
                                                <button type="button" @click="removeOption(qIndex, oIndex)" class="text-gray-400 hover:text-red-500" x-show="question.options.length > 2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                    <button type="button" @click="addOption(qIndex)" class="mt-3 text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Opsi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-8 flex justify-between items-center">
                    <button type="button" @click="addQuestion()" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-5 h-5 mr-2 -ml-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tambah Soal Lain
                    </button>

                    <div class="flex gap-4">
                        <a href="{{ route('quizzes.index') }}">
                            <x-secondary-button type="button">Batal</x-secondary-button>
                        </a>
                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">Simpan & Publikasikan</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function quizForm() {
            return {
                questions: [
                    {
                        id: Date.now(),
                        type: 'multiple_choice',
                        options: [{}, {}, {}, {}] 
                    }
                ],
                addQuestion() {
                    this.questions.push({
                        id: Date.now(),
                        type: 'multiple_choice',
                        options: [{}, {}, {}, {}]
                    });
                },
                removeQuestion(index) {
                    this.questions.splice(index, 1);
                },
                addOption(qIndex) {
                    this.questions[qIndex].options.push({});
                },
                removeOption(qIndex, oIndex) {
                    this.questions[qIndex].options.splice(oIndex, 1);
                }
            }
        }
    </script>
</x-app-layout>