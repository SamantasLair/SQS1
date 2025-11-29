<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - SQS</title>
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-2xl font-bold mb-4">Memproses Pembayaran...</h1>
        <p class="text-gray-400">Mohon tunggu, popup pembayaran akan segera muncul.</p>
        
        <div class="mt-8">
            <button id="pay-button" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 rounded-lg font-bold transition-all">
                Bayar Sekarang
            </button>
        </div>
        
        <div class="mt-4">
            <a href="{{ route('pricing.index') }}" class="text-sm text-gray-500 hover:text-gray-300">Batalkan</a>
        </div>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        
        function triggerPayment() {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    window.location.href = "{{ route('payment.success') }}";
                },
                onPending: function(result){
                    window.location.href = "{{ route('dashboard') }}";
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                    window.location.href = "{{ route('pricing.index') }}";
                },
                onClose: function(){
                    alert('Anda menutup popup pembayaran.');
                }
            });
        }

        payButton.addEventListener('click', triggerPayment);

        setTimeout(triggerPayment, 1000);
    </script>
</body>
</html>