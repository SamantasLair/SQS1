<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Moderasi Kuis
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-700">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-gray-300">
                            <thead class="bg-gray-900/50 uppercase text-xs font-bold text-gray-400">
                                <tr>
                                    <th class="px-6 py-4">Judul Kuis</th>
                                    <th class="px-6 py-4">Pembuat</th>
                                    <th class="px-6 py-4">Kode</th>
                                    <th class="px-6 py-4">Soal</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach($quizzes as $quiz)
                                    <tr class="hover:bg-gray-700/50 transition">
                                        <td class="px-6 py-4 font-medium text-white">{{ $quiz->title }}</td>
                                        <td class="px-6 py-4">{{ $quiz->user->name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-4 font-mono text-indigo-400">{{ $quiz->join_code }}</td>
                                        <td class="px-6 py-4">{{ $quiz->questions_count }}</td>
                                        <td class="px-6 py-4 flex justify-end gap-2">
                                            <a href="{{ route('admin.quizzes.show', $quiz) }}" class="px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white rounded text-sm transition">
                                                Detail
                                            </a>
                                            <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('Hapus kuis ini secara permanen?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-500 text-white rounded text-sm transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $quizzes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>