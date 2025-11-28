<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ $quiz->title }}</h2>
            <a href="{{ route('quizzes.edit', $quiz) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">Edit Kuis</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-3">
                        <h3 class="font-bold text-lg mb-2">Deskripsi</h3>
                        <p class="text-gray-600">{{ $quiz->description ?: '-' }}</p>
                    </div>
                    <div class="bg-gray-100 p-4 rounded text-center">
                        <div class="text-xs text-gray-500 uppercase">Kode Join</div>
                        <div class="text-2xl font-mono font-bold text-blue-600">{{ $quiz->join_code }}</div>
                        <div class="text-xs text-gray-500 uppercase mt-2">Waktu</div>
                        <div class="font-bold">{{ $quiz->timer }} Menit</div>
                        <div class="text-xs text-gray-500 uppercase mt-2">Soal</div>
                        <div class="font-bold">{{ $quiz->questions->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                @foreach($quiz->questions as $index => $question)
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="flex gap-4">
                        <div class="bg-blue-100 text-blue-800 font-bold w-8 h-8 flex items-center justify-center rounded-full shrink-0">{{ $index + 1 }}</div>
                        <div class="grow">
                            <p class="text-lg font-medium mb-4">{{ $question->question_text }}</p>
                            @if($question->question_type === 'multiple_choice')
                                <div class="space-y-2">
                                    @foreach($question->options as $option)
                                    <div class="p-3 rounded border {{ $option->is_correct ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-transparent' }}">
                                        <span class="{{ $option->is_correct ? 'font-bold text-green-700' : '' }}">{{ $option->option_text }}</span>
                                        @if($option->is_correct) <span class="ml-2 text-xs bg-green-200 text-green-800 px-2 py-0.5 rounded">Benar</span> @endif
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-yellow-50 p-3 rounded border border-yellow-200 text-yellow-800 text-sm">Soal Essay</div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>