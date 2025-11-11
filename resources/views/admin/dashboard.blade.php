<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center h-16">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h2>
                <p class="text-gray-600">Mari kita mulai belajar dan membuat kuis hari ini.</p>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" /></svg>
                </div>
                <input type="text" placeholder="Cari kuis..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">
        <div>
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Statistik</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                    <div class="flex-shrink-0 bg-blue-100 text-blue-600 rounded-full p-3">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M3.5 3.75a.25.25 0 01.25-.25h12.5a.25.25 0 01.25.25v12.5a.25.25 0 01-.25.25H3.75a.25.25 0 01-.25-.25V3.75zM5 6.25v1.5h10v-1.5H5zm0 3v1.5h10v-1.5H5zm0 3v1.5h10v-1.5H5z" /></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Kuis (Global)</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalKuis }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                    <div class="flex-shrink-0 bg-green-100 text-green-600 rounded-full p-3">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 00-2.824-2.824l-1.047-.348a3 3 0 00-3.416 3.416l.348 1.047a3 3 0 002.824 2.824l1.047.348a3 3 0 003.416-3.416l-.348-1.047zM17.828 15a5 5 0 01-7.07 0l-1.047-.348a5 5 0 01-3.416-3.416l-.348-1.047a5 5 0 010-7.07l.348-1.047a5 5 0 013.416-3.416l1.047-.348a5 5 0 017.07 0l1.047.348a5 5 0 013.416 3.416l.348 1.047a5 5 0 010 7.07l-.348 1.047a5 5 0 01-3.416 3.416l-1.047.348z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Kuis Dikerjakan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $kuisDikerjakan }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                    <div class="flex-shrink-0 bg-yellow-100 text-yellow-600 rounded-full p-3">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15.22 6.268a.75.75 0 01.032 1.06l-5.25 6.5a.75.75 0 01-1.088.018l-3.25-3.5a.75.75 0 111.088-1.036l2.704 2.923 4.71-5.83a.75.75 0 011.06-.032zM2.75 4.25a.75.75 0 01.75-.75h13a.75.75 0 010 1.5h-13a.75.75 0 01-.75-.75z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Rata-rata Skor</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($rataRataSkor, 0) }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md flex items-center">
                    <div class="flex-shrink-0 bg-purple-100 text-purple-600 rounded-full p-3">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15.22 6.268a.75.75 0 01.032 1.06l-5.25 6.5a.75.75 0 01-1.088.018l-3.25-3.5a.75.75 0 111.088-1.036l2.704 2.923 4.71-5.83a.75.75 0 011.06-.032zM2.75 4.25a.75.75 0 01.75-.75h13a.75.75 0 010 1.5h-13a.75.75 0 01-.75-.75z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Peringkat (Coming Soon)</p>
                        <p class="text-2xl font-bold text-gray-900">#1</p>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900">Kuis Terbaru</h3>
                <a href="{{ route('quizzes.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Lihat Semua</a>
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <ul class="divide-y divide-gray-200">
                    @forelse($kuisTerbaru as $quiz)
                    <li class="p-4 flex justify-between items-center hover:bg-gray-50">
                        <div>
                            <p class="text-base font-semibold text-gray-900">{{ $quiz->title }}</p>
                            <p class="text-sm text-gray-600">Dibuat oleh {{ $quiz->user->name }} &middot; {{ $quiz->questions->count() }} Pertanyaan</p>
                        </div>
                        <div>
                            <a href="{{ route('quizzes.start', $quiz) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500">
                                Mulai Kuis
                            </a>
                        </div>
                    </li>
                    @empty
                    <li class="p-4 text-center text-gray-500">
                        Belum ada kuis yang dibuat.
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>