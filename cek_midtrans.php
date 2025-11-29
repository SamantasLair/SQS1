<?php
require 'vendor/autoload.php'; // Pastikan path ini benar

use Midtrans\Config;
use Midtrans\Snap;

// --- KONFIGURASI MANUAL ---
// Masukkan Key Anda di sini
$myServerKey = 'SB-Mid-server-OXyf8hqSwvk3VsVW4FinLeyZ'; 

// Tentukan environment berdasarkan prefix key
$isProduction = (strpos($myServerKey, 'SB-') === false); 

echo "----------------------------------------\n";
echo "Testing Midtrans Connection...\n";
echo "Key Prefix: " . substr($myServerKey, 0, 15) . "...\n";
echo "Environment: " . ($isProduction ? "PRODUCTION" : "SANDBOX") . "\n";
echo "----------------------------------------\n";

Config::$serverKey = $myServerKey;
Config::$isProduction = $isProduction;
Config::$isSanitized = true;
Config::$is3ds = true;

$params = [
    'transaction_details' => [
        'order_id' => 'TEST-DEBUG-' . time(),
        'gross_amount' => 10000,
    ]
];

try {
    $snapToken = Snap::getSnapToken($params);
    echo "✅ SUKSES! Key Valid.\n";
    echo "Snap Token: " . $snapToken . "\n";
} catch (\Exception $e) {
    echo "❌ GAGAL! Pesan Error:\n";
    echo $e->getMessage() . "\n";
    
    if (strpos($e->getMessage(), '401') !== false) {
        echo "\nANALISIS:\n";
        echo "Error 401 berarti Key ditolak oleh Midtrans.\n";
        if ($isProduction) {
            echo "- Anda menggunakan Key PRODUCTION. Pastikan akun Midtrans sudah aktif/live.\n";
        } else {
            echo "- Anda menggunakan Key SANDBOX.\n";
        }
        echo "- Cek apakah ada spasi tersembunyi di akhir Key.\n";
        echo "- Pastikan ini SERVER KEY, bukan CLIENT KEY.\n";
    }
}
echo "----------------------------------------\n";