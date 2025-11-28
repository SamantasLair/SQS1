<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-3xl w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border-t-4 border-indigo-600">
                <div class="p-8 text-center">
                    
                    <div class="inline-block p-4 rounded-full bg-indigo-50 mb-6">
                        <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>

                    <h2 class="text-3xl font-extrabold text-gray-900 mb-2">
                        {{ $quiz->title }}
                    </h2>
                    
                    <p class="text-gray-500 mb-8 max-w-lg mx-auto">
                        {{ $quiz->description ?? 'Persiapkan dirimu, waktu akan berjalan otomatis setelah kamu menekan tombol mulai.' }}
                    </p>

                    <div class="grid grid-cols-2 gap-4 max-w-md mx-auto mb-8 bg-gray-50 p-4 rounded-xl">
                        <div class="text-center border-r border-gray-200">
                            <span class="block text-gray-400 text-xs uppercase font-bold">Durasi</span>
                            <span class="block text-xl font-bold text-gray-800">{{ $quiz->time_limit }} Menit</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-gray-400 text-xs uppercase font-bold">Total Soal</span>
                            <span class="block text-xl font-bold text-gray-800">{{ $quiz->questions_count ?? 0 }}</span>
                        </div>
                    </div>

                    <form action="{{ route('quizzes.start', $quiz) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full max-w-sm px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-lg font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transform transition duration-300">
                            Mulai Kuis Sekarang 🔥
                        </button>
                    </form>
                    
                    <div class="mt-6">
                        <a href="{{ route('quizzes.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium">
                            &larr; Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>