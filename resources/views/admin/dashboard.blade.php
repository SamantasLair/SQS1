<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-indigo-600 rounded-lg shadow-xl p-6 mb-8 text-white flex justify-between items-center relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-2xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-indigo-100">Berikut adalah ringkasan aktivitas platform SQS hari ini.</p>
                </div>
                <div class="absolute right-0 bottom-0 opacity-10 transform translate-y-1/4 translate-x-1/4">
                    <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.75l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">Total Pengguna</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalUsers) }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <span class="text-indigo-600 font-semibold mr-1">{{ $premiumUsers }}</span> Premium
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">Total Pendapatan</p>
                            <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                     <div class="mt-4 flex items-center text-sm text-gray-500">
                        <span class="text-green-600 font-semibold mr-1">Verified</span> Transaksi Sukses
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">Total Kuis</p>
                            <p class="text-2xl font-bold text-gray-800">{{ number_format($totalQuizzes) }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <span class="text-purple-600 font-semibold mr-1">{{ $totalAttempts }}</span> Kali Dikerjakan
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="mb-2 text-sm font-medium text-gray-600">Aktivitas</p>
                            <p class="text-2xl font-bold text-gray-800">Aktif</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        Platform berjalan normal
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Pengguna Terbaru</h3>
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500">
                                <tr>
                                    <th class="px-6 py-4">Nama</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-right">Bergabung</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($recentUsers as $user)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-800 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($user->is_premium)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gradient-to-r from-amber-200 to-yellow-400 text-yellow-800">
                                                Premium
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Free
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-xs">{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada pengguna.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-800">Transaksi Terbaru</h3>
                        <span class="text-xs text-gray-500">5 Transaksi Terakhir</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600">
                            <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500">
                                <tr>
                                    <th class="px-6 py-4">User</th>
                                    <th class="px-6 py-4">Jumlah</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-right">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($recentTransactions as $transaction)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-800">
                                        {{ $transaction->user->name ?? 'Deleted User' }}
                                        <div class="text-xs text-gray-400 font-normal">{{ $transaction->order_id }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-semibold">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($transaction->status == 'success')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Sukses
                                            </span>
                                        @elseif($transaction->status == 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ ucfirst($transaction->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right text-xs">{{ $transaction->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-400">Belum ada transaksi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-8 bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Kuis Terpopuler</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                    @forelse($popularQuizzes as $quiz)
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-gray-800 line-clamp-1" title="{{ $quiz->title }}">{{ $quiz->title }}</h4>
                            <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded font-bold">
                                {{ $quiz->attempts_count }}x
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $quiz->description ?? 'Tidak ada deskripsi.' }}</p>
                        <div class="flex items-center justify-between text-xs text-gray-400">
                            <span>Oleh: {{ $quiz->user->name }}</span>
                            <span>{{ $quiz->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center text-gray-400 py-4">Belum ada data kuis populer.</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>