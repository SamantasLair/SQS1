<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kuis Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('quizzes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Buat Kuis Baru
                    </a>
                    
                    <h3 class="font-semibold text-lg mt-6">Daftar Kuis Anda:</h3>
                    <ul class="mt-4 space-y-2">
                        @forelse ($quizzes as $quiz)
                            <li class="flex justify-between items-center p-3 border rounded-lg">
                                <div>
                                    <span class="font-semibold">{{ $quiz->title }}</span>
                                    @if($quiz->join_code)
                                    <div class="flex items-center mt-1">
                                        <span class="text-sm text-gray-600 mr-2">Kode:</span>
                                        <span class="font-mono bg-gray-200 px-2 py-1 rounded text-gray-800 font-semibold">{{ $quiz->join_code }}</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('quizzes.leaderboard', $quiz) }}" class="text-blue-600 hover:text-blue-900 font-medium">Leaderboard</a>
                                    <a href="{{ route('quizzes.start', $quiz) }}" class="text-green-600 hover:text-green-900 font-bold">Mulai Kuis</a>
                                    <a href="{{ route('quizzes.edit', $quiz) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Apakah Anda yakin ingin menghapus kuis ini?')">Hapus</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li>Anda belum membuat kuis.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>