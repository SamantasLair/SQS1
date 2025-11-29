<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Checkout {{ ucfirst($plan) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white text-center">
                    <h3 class="text-2xl font-bold mb-4">Konfirmasi Pembayaran</h3>
                    <p class="mb-6">Anda akan melakukan pembayaran sebesar <span class="font-bold text-indigo-400">Rp {{ number_format($amount, 0, ',', '.') }}</span> untuk paket <span class="font-bold text-indigo-400">{{ ucfirst($plan) }}</span>.</p>
                    
                    <button id="pay-button" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg font-bold shadow-lg transition">
                        Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="[https://app.sandbox.midtrans.com/snap/snap.js](https://app.sandbox.midtrans.com/snap/snap.js)" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    window.location.href = "{{ route('payment.success') }}?order_id={{ $snapToken }}"; // Perlu menyesuaikan logic redirect di controller success jika menggunakan snapToken sebagai ref atau order_id dari result
                },
                onPending: function(result){
                    window.location.href = "{{ route('dashboard') }}";
                },
                onError: function(result){
                    window.location.href = "{{ route('dashboard') }}";
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        };
    </script>
</x-app-layout>