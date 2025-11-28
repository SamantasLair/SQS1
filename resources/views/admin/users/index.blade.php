<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Kuis Tersedia') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <p class="text-gray-600">Pilih kuis di bawah ini untuk mulai mengerjakan.</p>
                <a href="{{ route('quizzes.join') }}" class="text-indigo-600 font-semibold hover:underline">Punya kode kuis? Masukkan disini &rarr;</a>
            </div>

            @if($quizzes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($quizzes as $quiz)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition duration-300 border border-gray-100 overflow-hidden flex flex-col">
                            <div class="h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>
                            <div class="p-6 flex-1">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="px-2 py-1 text-xs font-bold text-indigo-600 bg-indigo-50 rounded-md uppercase tracking-wide">
                                        {{ $quiz->questions_count ?? 0 }} Soal
                                    </span>
                                    <span class="text-gray-400 text-sm">
                                        {{ $quiz->time_limit }} Menit
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $quiz->title }}</h3>
                                <p class="text-gray-500 text-sm line-clamp-2 mb-4">
                                    {{ $quiz->description ?? 'Tidak ada deskripsi untuk kuis ini.' }}
                                </p>
                            </div>
                            <div class="p-6 pt-0 mt-auto">
                                <a href="{{ route('quizzes.show', $quiz) }}" class="block w-full text-center py-2 px-4 bg-gray-900 text-white font-semibold rounded-lg hover:bg-indigo-600 transition duration-300">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white p-8 rounded-xl shadow-sm text-center">
                    <div class="text-gray-300 text-6xl mb-4">📂</div>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada kuis tersedia</h3>
                    <p class="text-gray-500 mt-1">Silakan tunggu admin menambahkan kuis baru.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>