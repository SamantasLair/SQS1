<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Edit User: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 shadow-sm sm:rounded-lg border border-gray-700 p-6">
                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Role</label>
                        <select name="role" class="w-full bg-gray-900 border border-gray-600 text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User (Free)</option>
                            <option value="pro" {{ $user->role === 'pro' ? 'selected' : '' }}>Pro</option>
                            <option value="premium" {{ $user->role === 'premium' ? 'selected' : '' }}>Premium</option>
                            <option value="academic" {{ $user->role === 'academic' ? 'selected' : '' }}>Academic</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Masa Aktif Langganan (Opsional)</label>
                        <input type="date" name="subscription_ends_at" 
                            value="{{ $user->subscription_ends_at ? \Carbon\Carbon::parse($user->subscription_ends_at)->format('Y-m-d') : '' }}"
                            class="w-full bg-gray-900 border border-gray-600 text-white rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="text-xs text-gray-500 mt-1">Kosongkan jika role adalah User Free atau Admin.</p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-500 transition shadow-lg shadow-indigo-600/20">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>