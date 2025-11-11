<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gabung Kuis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('quizzes.join.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="code" class="block font-medium text-sm text-gray-700">Masukkan Kode Kuis (6 Digit)</label>
                            <input type="text" name="code" id="code" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 uppercase" required maxlength="6" minlength="6">
                            
                            @if(session('error'))
                                <p class="text-sm text-red-600 mt-2">{{ session('error') }}</p>
                            @endif
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Gabung
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>