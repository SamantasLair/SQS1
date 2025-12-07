<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Manajemen User
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
                                    <th class="px-6 py-4">Nama</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4">Role</th>
                                    <th class="px-6 py-4">Langganan Berakhir</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-700/50 transition">
                                        <td class="px-6 py-4 font-medium text-white">{{ $user->name }}</td>
                                        <td class="px-6 py-4">{{ $user->email }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs rounded font-bold
                                                {{ $user->role === 'admin' ? 'bg-red-900/50 text-red-400' : 
                                                   ($user->role === 'premium' ? 'bg-indigo-900/50 text-indigo-400' : 
                                                   ($user->role === 'pro' ? 'bg-blue-900/50 text-blue-400' : 'bg-gray-700 text-gray-400')) }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $user->subscription_ends_at ? \Carbon\Carbon::parse($user->subscription_ends_at)->format('d M Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 flex justify-end gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-500 text-white rounded text-sm transition">
                                                Edit
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1 bg-red-600 hover:bg-red-500 text-white rounded text-sm transition">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>