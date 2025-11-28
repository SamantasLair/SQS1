<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kuis
        </h2>
    </x-slot>

    <div class="py-12" x-data="quizEditor(@js($quiz->questions->load('options')))">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">{{ session('error') }}</div>
            @endif

            <form action="{{ route('quizzes.update', $quiz) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white shadow-sm sm:rounded-lg mb-6 p-6">
                    <h3 class="text-lg font-medium mb-4">Detail Kuis</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <input type="text" name="title" value="{{ old('title', $quiz->title) }}" class="w-full rounded-md border-gray-300" required>
                        <textarea name="description" rows="2" class="w-full rounded-md border-gray-300">{{ old('description', $quiz->description) }}</textarea>
                        <input type="number" name="timer" value="{{ old('timer', $quiz->timer) }}" class="w-full rounded-md border-gray-300" required>
                    </div>
                </div>

                <div class="space-y-6">
                    <template x-for="(question, qIndex) in questions" :key="question.temp_id">
                        <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-200">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-bold text-indigo-700" x-text="'Soal ' + (qIndex + 1)"></h4>
                                <button type="button" @click="removeQuestion(qIndex)" class="text-red-500 text-sm">Hapus</button>
                            </div>
                            
                            <input type="hidden" :name="'questions['+qIndex+'][id]'" :value="question.id">
                            <textarea :name="'questions['+qIndex+'][text]'" x-model="question.question_text" rows="2" class="w-full rounded-md border-gray-300 mb-3" placeholder="Tulis pertanyaan..." required></textarea>
                            
                            <select :name="'questions['+qIndex+'][question_type]'" x-model="question.question_type" class="w-full rounded-md border-gray-300 mb-4">
                                <option value="multiple_choice">Pilihan Ganda</option>
                                <option value="essay">Essay</option>
                            </select>

                            <div x-show="question.question_type === 'multiple_choice'" class="ml-4 border-l-2 pl-4">
                                <template x-for="(option, oIndex) in question.options" :key="oIndex">
                                    <div class="flex items-center gap-2 mb-2">
                                        <input type="radio" :name="'questions['+qIndex+'][correct_option]'" :value="oIndex" :checked="option.is_correct" required>
                                        <input type="hidden" :name="'questions['+qIndex+'][options]['+oIndex+'][id]'" :value="option.id">
                                        <input type="text" :name="'questions['+qIndex+'][options]['+oIndex+'][text]'" x-model="option.option_text" class="w-full rounded-md border-gray-300" placeholder="Pilihan jawaban">
                                        <button type="button" @click="removeOption(qIndex, oIndex)" class="text-red-500">X</button>
                                    </div>
                                </template>
                                <button type="button" @click="addOption(qIndex)" class="text-sm text-blue-600">+ Tambah Opsi</button>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-6 flex justify-between sticky bottom-4 bg-gray-100 p-4 rounded-lg shadow">
                    <button type="button" @click="addQuestion()" class="bg-white border px-4 py-2 rounded">Tambah Soal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Semua Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('quizEditor', (initialData) => ({
                questions: [],
                init() {
                    this.questions = initialData.length ? initialData.map(q => ({
                        id: q.id,
                        temp_id: Math.random().toString(36).substr(2, 9),
                        question_text: q.question_text,
                        question_type: q.question_type, 
                        options: q.options ? q.options.map(o => ({
                            id: o.id,
                            option_text: o.option_text,
                            is_correct: o.is_correct == 1
                        })) : []
                    })) : [];
                },
                addQuestion() {
                    this.questions.push({
                        id: null,
                        temp_id: Math.random().toString(36).substr(2, 9),
                        question_text: '',
                        question_type: 'multiple_choice',
                        options: [{id:null, option_text:'', is_correct:false}, {id:null, option_text:'', is_correct:false}]
                    });
                },
                removeQuestion(index) {
                    if(confirm('Hapus soal ini?')) this.questions.splice(index, 1);
                },
                addOption(qIndex) {
                    this.questions[qIndex].options.push({id:null, option_text:'', is_correct:false});
                },
                removeOption(qIndex, oIndex) {
                    this.questions[qIndex].options.splice(oIndex, 1);
                }
            }));
        });
    </script>
</x-app-layout>