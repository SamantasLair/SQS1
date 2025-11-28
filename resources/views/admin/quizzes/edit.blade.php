<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kuis: {{ $quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('quizzes.update', $quiz) }}" method="POST" id="quiz-form">
                @csrf
                @method('PUT')

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Pengaturan Kuis</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="title" value="Judul" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="$quiz->title" required />
                        </div>
                        <div>
                            <x-input-label for="time_limit" value="Durasi (Menit)" />
                            <x-text-input id="time_limit" class="block mt-1 w-full" type="number" name="time_limit" :value="$quiz->time_limit" required />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="description" value="Deskripsi" />
                            <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="2">{{ $quiz->description }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="space-y-6" id="questions-container">
                    @foreach($quiz->questions as $index => $question)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 relative question-item">
                            <button type="button" class="absolute top-4 right-4 text-red-500 hover:text-red-700 font-bold" onclick="removeQuestion(this)">
                                &times; Hapus Soal
                            </button>
                            
                            <div class="mb-4">
                                <label class="block font-medium text-sm text-gray-700 mb-1">Pertanyaan #{{ $index + 1 }}</label>
                                <textarea name="questions[{{ $index }}][text]" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" rows="2" required>{{ $question->question_text }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($question->options as $optIndex => $option)
                                    <div class="flex items-center space-x-2 p-3 border rounded-lg {{ $option->is_correct ? 'bg-green-50 border-green-200' : 'bg-gray-50' }}">
                                        <input type="radio" name="correct_answers[{{ $index }}]" value="{{ $optIndex }}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ $option->is_correct ? 'checked' : '' }} required>
                                        <input type="text" name="questions[{{ $index }}][options][{{ $optIndex }}][text]" value="{{ $option->option_text }}" class="flex-1 block w-full border-gray-300 rounded-md shadow-sm text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 flex justify-between items-center">
                    <button type="button" onclick="addQuestion()" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition">
                        + Tambah Soal Manual
                    </button>
                    
                    <div class="space-x-3">
                        <a href="{{ route('quizzes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-lg shadow hover:bg-indigo-700 transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        let questionCount = {{ $quiz->questions->count() }};

        function addQuestion() {
            const container = document.getElementById('questions-container');
            const template = `
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 relative question-item mt-6">
                    <button type="button" class="absolute top-4 right-4 text-red-500 hover:text-red-700 font-bold" onclick="removeQuestion(this)">&times; Hapus Soal</button>
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 mb-1">Pertanyaan Baru</label>
                        <textarea name="questions[${questionCount}][text]" class="w-full border-gray-300 rounded-md shadow-sm" rows="2" required></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        ${[0, 1, 2, 3].map(i => `
                            <div class="flex items-center space-x-2 p-3 border rounded-lg bg-gray-50">
                                <input type="radio" name="correct_answers[${questionCount}]" value="${i}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" ${i===0 ? 'checked' : ''} required>
                                <input type="text" name="questions[${questionCount}][options][${i}][text]" class="flex-1 block w-full border-gray-300 rounded-md shadow-sm text-sm" placeholder="Pilihan ${String.fromCharCode(65+i)}" required>
                            </div>
                        `).join('')}
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
            questionCount++;
        }

        function removeQuestion(btn) {
            if(confirm('Hapus soal ini?')) {
                btn.closest('.question-item').remove();
            }
        }
    </script>
</x-app-layout>