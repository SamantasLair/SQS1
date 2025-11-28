<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-3xl text-white tracking-tight drop-shadow-md">
            Edit Kuis
        </h2>
    </x-slot>

    <div class="py-12" x-data="quizEditor(@js($quiz->questions->load('options')))">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-500/20 border border-green-500/50 text-green-200 px-6 py-4 rounded-xl shadow-lg font-medium">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-500/20 border border-red-500/50 text-red-200 px-6 py-4 rounded-xl shadow-lg font-medium">{{ session('error') }}</div>
            @endif

            <form action="{{ route('quizzes.update', $quiz) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white/5 backdrop-blur-xl border border-white/10 shadow-xl sm:rounded-2xl mb-8 p-8">
                    <h3 class="text-xl font-bold text-white mb-6 border-b border-white/10 pb-4">Detail Kuis</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Judul</label>
                            <input type="text" name="title" value="{{ old('title', $quiz->title) }}" class="w-full rounded-xl bg-black/20 border-gray-600 text-white focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Deskripsi</label>
                            <textarea name="description" rows="2" class="w-full rounded-xl bg-black/20 border-gray-600 text-white focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $quiz->description) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Timer (Menit)</label>
                            <input type="number" name="timer" value="{{ old('timer', $quiz->timer) }}" class="w-full rounded-xl bg-black/20 border-gray-600 text-white focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <template x-for="(question, qIndex) in questions" :key="question.temp_id">
                        <div class="bg-white/5 backdrop-blur-md border border-white/10 shadow-lg sm:rounded-2xl p-6 relative group transition hover:bg-white/[0.07]">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-bold text-indigo-400 text-lg" x-text="'Soal ' + (qIndex + 1)"></h4>
                                <button type="button" @click="removeQuestion(qIndex)" class="text-red-400 hover:text-red-300 text-sm font-semibold bg-red-500/10 px-3 py-1 rounded-lg border border-red-500/20 transition">Hapus</button>
                            </div>
                            
                            <input type="hidden" :name="'questions['+qIndex+'][id]'" :value="question.id">
                            <textarea :name="'questions['+qIndex+'][text]'" x-model="question.question_text" rows="2" class="w-full rounded-xl bg-black/20 border-gray-600 text-white mb-4 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Tulis pertanyaan..." required></textarea>
                            
                            <select :name="'questions['+qIndex+'][question_type]'" x-model="question.question_type" class="w-full rounded-xl bg-black/20 border-gray-600 text-white mb-6 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="multiple_choice">Pilihan Ganda</option>
                                <option value="essay">Essay</option>
                            </select>

                            <div x-show="question.question_type === 'multiple_choice'" class="ml-4 border-l-2 border-indigo-500/30 pl-6 space-y-3">
                                <template x-for="(option, oIndex) in question.options" :key="oIndex">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" :name="'questions['+qIndex+'][correct_option]'" :value="oIndex" :checked="option.is_correct" required class="bg-black/20 border-gray-500 text-indigo-500 focus:ring-indigo-500">
                                        <input type="hidden" :name="'questions['+qIndex+'][options]['+oIndex+'][id]'" :value="option.id">
                                        <input type="text" :name="'questions['+qIndex+'][options]['+oIndex+'][text]'" x-model="option.option_text" class="w-full rounded-lg bg-black/20 border-gray-600 text-white text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Pilihan jawaban">
                                        <button type="button" @click="removeOption(qIndex, oIndex)" class="text-gray-500 hover:text-red-400 transition font-bold px-2">&times;</button>
                                    </div>
                                </template>
                                <button type="button" @click="addOption(qIndex)" class="text-sm font-semibold text-indigo-400 hover:text-indigo-300 flex items-center gap-1 mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Opsi
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-8 flex justify-between items-center sticky bottom-6 bg-gray-900/90 backdrop-blur-xl p-4 rounded-2xl shadow-2xl border border-white/10 z-20">
                    <button type="button" @click="addQuestion()" class="bg-white/10 hover:bg-white/20 text-white border border-white/20 px-6 py-3 rounded-xl font-semibold transition">
                        + Tambah Soal
                    </button>
                    <button type="submit" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:shadow-indigo-500/30 hover:scale-105 transition transform">
                        Simpan Perubahan
                    </button>
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