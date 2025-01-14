<?php
require_once dirname(__FILE__) . '/midtrans-php-master/Midtrans.php';

// Set konfigurasi Midtrans
\Midtrans\Config::$serverKey = 'SB-Mid-server-XUlNaB_fYw_KXZBTyDQmayCx';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Baca data JSON
$data = json_decode(file_get_contents('php://input'), true);


// Validasi data JSON
if (!isset($data["member_id"]) || !isset($data["total_price"]) || !isset($data["cart_data"]) ||
    !isset($data["nama_depan"]) || !isset($data["nama_belakang"]) ||
    !isset($data["email"]) || !isset($data["phone"])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Data tidak lengkap."]);
    exit;
}

// Simpan transaksi ke database
$saleTotalPrice = (int) $data["total_price"];
$saleDate = date("Y-m-d H:i:s");
$user_id = isset($data["user_id"]) ? (int)$data["user_id"] : 1; // Default user_id jika tidak disediakan
$member_id = (int)$data["member_id"]; // Pastikan member_id dikonversi ke integer
$detailSale = $data["cart_data"];
$status = "pending";



require_once __DIR__ . '../../../model/modelSaleSql.php';

$modelSale = new modelSaleSql();

 // Pastikan semua parameter sesuai tipe
 $saleId = $modelSale->addMitransSale($detailSale,  $saleTotalPrice, $saleDate,  $user_id,  $member_id,  $status);
 if (!$saleId) {
     throw new Exception("Gagal menyimpan transaksi ke database.");
 }


// Konversi cart_data ke item_details
$item_details = [];
foreach ($data["cart_data"] as $item) {
    $item_details[] = [
        'id' => $item['item_id'],
        'name' => $item['item_name'],
        'price' => (int) $item['item_price'],
        'quantity' => isset($item['quantity']) ? (int) $item['quantity'] : 1,
    ];
}
// Persiapkan parameter transaksi
$params = [
    'transaction_details' => [
        'order_id' => $saleId,
        'gross_amount' => (int) $data["total_price"],
    ],
    'item_details' => $item_details,
    'customer_details' => [
        'first_name' => htmlspecialchars($data["nama_depan"]),
        'last_name' => htmlspecialchars($data["nama_belakang"]),
        'email' => htmlspecialchars($data["email"]),
        'phone' => htmlspecialchars($data["phone"]),
    ],
];
// Dapatkan Snap Token
try {
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    echo $snapToken;
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => $e->getMessage()]);
}