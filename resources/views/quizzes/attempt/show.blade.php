<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-3xl text-white tracking-tight drop-shadow-md">{{ $quiz->title }}</h2>
            <a href="{{ route('quizzes.edit', $quiz) }}" class="bg-white/10 hover:bg-white/20 border border-white/20 text-white px-4 py-2 rounded-xl text-sm font-bold backdrop-blur-md transition">Edit Kuis</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/5 backdrop-blur-md border border-white/10 shadow-xl sm:rounded-2xl p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="md:col-span-3">
                        <h3 class="font-bold text-xl text-white mb-2">Deskripsi</h3>
                        <p class="text-gray-300 leading-relaxed">{{ $quiz->description ?: '-' }}</p>
                    </div>
                    <div class="bg-black/20 p-4 rounded-xl border border-white/5 text-center">
                        <div class="text-xs text-indigo-300 uppercase font-bold tracking-wider">Kode Join</div>
                        <div class="text-3xl font-mono font-black text-white my-1">{{ $quiz->join_code }}</div>
                        
                        <div class="grid grid-cols-2 gap-2 mt-4 pt-4 border-t border-white/10">
                            <div>
                                <div class="text-xs text-gray-400 uppercase">Waktu</div>
                                <div class="font-bold text-white">{{ $quiz->timer }} Menit</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-400 uppercase">Soal</div>
                                <div class="font-bold text-white">{{ $quiz->questions->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                @foreach($quiz->questions as $index => $question)
                <div class="bg-white/5 backdrop-blur-md border border-white/10 shadow-lg sm:rounded-2xl p-6 hover:bg-white/10 transition duration-300">
                    <div class="flex gap-4">
                        <div class="bg-indigo-600 text-white font-bold w-8 h-8 flex items-center justify-center rounded-full shrink-0 shadow-lg">{{ $index + 1 }}</div>
                        <div class="grow">
                            <p class="text-lg font-medium text-white mb-4">{{ $question->question_text }}</p>
                            @if($question->question_type === 'multiple_choice')
                                <div class="space-y-2">
                                    @foreach($question->options as $option)
                                    <div class="p-3 rounded-lg border {{ $option->is_correct ? 'bg-green-500/20 border-green-500/50' : 'bg-black/20 border-white/5' }} flex items-center">
                                        <span class="{{ $option->is_correct ? 'font-bold text-green-300' : 'text-gray-300' }}">{{ $option->option_text }}</span>
                                        @if($option->is_correct) <span class="ml-auto text-xs bg-green-500 text-white px-2 py-0.5 rounded-full font-bold shadow">Benar</span> @endif
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-yellow-500/20 p-3 rounded-lg border border-yellow-500/30 text-yellow-200 text-sm flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Soal Essay
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>