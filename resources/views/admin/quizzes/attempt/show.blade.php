<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mengerjakan: {{ $attempt->quiz->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-600">Pertanyaan {{ $progress }}</p>
                        <h3 class="text-2xl font-semibold mt-1">{{ $question->question_text }}</h3>
                    </div>

                    <form action="{{ route('attempt.question.store', $attempt) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            @foreach ($question->options as $option)
                                <label for="option-{{ $option->id }}" class="block w-full p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="radio" name="option_id" value="{{ $option->id }}" id="option-{{ $option->id }}" class="mr-2" required>
                                    <span>{{ $option->option_text }}</span>
                                </label>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Lanjut
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>