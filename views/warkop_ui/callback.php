<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Metode tidak diizinkan
    exit('Method Not Allowed');
}

// Mengambil data dari request POST yang dikirim oleh Midtrans
$orderId = $_POST['order_id'] ;
$statusCode = $_POST['status_code'];
$grossAmount = $_POST['gross_amount'];
$signatureKey = $_POST['signature_key'];
$transactionStatus = $_POST['transaction_status'];

// Server Key Midtrans yang disimpan di konfigurasi
$serverKey = 'SB-Mid-server-XUlNaB_fYw_KXZBTyDQmayCx';

// Verifikasi signature dengan membuat hash
$hashed = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

if ($hashed == $signatureKey) {
    // Verifikasi status transaksi
    if ($transactionStatus == 'capture') {
        // Jika status transaksi adalah 'capture', maka perbarui status menjadi 'settlement'
        try {
           require_once __DIR__ . '../../../model/modelSaleSql.php';
           $modelSaleSql = new modelSaleSql();
           $modelSaleSql->updateStatus($orderId, 'settlement');
        
            // Eksekusi query
            if ($mysqli->query($sql) === TRUE) {
                echo "Transaksi berhasil, status diperbarui menjadi 'settlement'.";
            } else {
                echo "Error: " . $mysqli->error;
            }
        
            // Tutup koneksi
            $mysqli->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Status transaksi tidak sesuai.";
    }
} else {
    echo "Signature tidak valid.";
}


?>