<?php

// Simpan semua data yang diterima dari request ke file log untuk debugging
$logFile = __DIR__ . '/callback_test_log.txt';

// Ambil metode request
$method = $_SERVER['REQUEST_METHOD'];

// Simpan waktu dan metode request ke log
file_put_contents($logFile, "Request Time: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
file_put_contents($logFile, "Request Method: $method\n", FILE_APPEND);

if ($method === 'POST') {
    // Ambil data POST
    $postData = file_get_contents('php://input');
    file_put_contents($logFile, "POST Data: $postData\n", FILE_APPEND);

    // Berikan response 200 ke Midtrans
    http_response_code(200);
    echo "Callback received";
} else {
    // Jika bukan POST, berikan respons 405 (Method Not Allowed)
    http_response_code(405);
    echo "Method Not Allowed";
}

file_put_contents($logFile, "Response Sent\n\n", FILE_APPEND);
?>