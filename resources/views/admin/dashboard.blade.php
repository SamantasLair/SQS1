<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                    <div class="text-gray-400 text-sm font-bold uppercase mb-2">Total User</div>
                    <div class="text-3xl font-black text-white">{{ number_format($stats['total_users']) }}</div>
                </div>
                <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                    <div class="text-gray-400 text-sm font-bold uppercase mb-2">User Berbayar</div>
                    <div class="text-3xl font-black text-indigo-400">{{ number_format($stats['premium_users']) }}</div>
                </div>
                <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                    <div class="text-gray-400 text-sm font-bold uppercase mb-2">Total Kuis</div>
                    <div class="text-3xl font-black text-white">{{ number_format($stats['total_quizzes']) }}</div>
                </div>
                <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                    <div class="text-gray-400 text-sm font-bold uppercase mb-2">Pendapatan</div>
                    <div class="text-3xl font-black text-green-400">Rp {{ number_format($stats['total_revenue']) }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-gray-800 rounded-xl border border-gray-700 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-white">User Terbaru</h3>
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-indigo-400 hover:text-indigo-300">Lihat Semua</a>
                    </div>
                    <div class="space-y-4">
                        @foreach($stats['recent_users'] as $user)
                            <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-lg">
                                <div>
                                    <div class="text-white font-medium">{{ $user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                </div>
                                <span class="px-2 py-1 text-xs rounded bg-gray-700 text-gray-300">{{ ucfirst($user->role) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-gray-800 rounded-xl border border-gray-700 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-white">Transaksi Sukses Terbaru</h3>
                    </div>
                    <div class="space-y-4">
                        @foreach($stats['recent_transactions'] as $trx)
                            <div class="flex justify-between items-center p-3 bg-gray-900/50 rounded-lg">
                                <div>
                                    <div class="text-white font-medium">{{ $trx->user->name ?? 'Deleted User' }}</div>
                                    <div class="text-xs text-gray-500">{{ $trx->order_id }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-green-400 font-bold">Rp {{ number_format($trx->amount) }}</div>
                                    <div class="text-xs text-gray-500">{{ $trx->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>