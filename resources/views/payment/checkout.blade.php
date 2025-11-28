<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 leading-tight">
            Upgrade Premium
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                <h3 class="text-2xl font-bold mb-4">Langganan SQS Premium</h3>
                <p class="mb-6">Dapatkan akses unlimited AI Generator hanya dengan Rp {{ number_format($amount) }}</p>
                
                <button id="pay-button" class="px-6 py-3 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-500 transition">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            snap.pay('{{ $snapToken }}', {
                // Saat sukses bayar di popup
                onSuccess: function(result){
                    // Redirect ke fungsi success di controller dengan membawa Order ID
                    window.location.href = "{{ route('payment.success') }}?order_id=" + result.order_id;
                },
                // Saat status pending
                onPending: function(result){
                    alert("Menunggu pembayaran!");
                    // Opsional: Redirect juga ke success untuk cek status pending
                    // window.location.href = "{{ route('payment.success') }}?order_id=" + result.order_id;
                },
                // Saat error
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                // Saat popup ditutup manual
                onClose: function(){
                    alert('Anda menutup popup pembayaran sebelum menyelesaikan transaksi');
                }
            });
        };
    </script>
</x-app-layout>