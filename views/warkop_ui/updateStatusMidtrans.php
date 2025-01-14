<?php
require_once __DIR__ . '../../../model/modelSaleSql.php';

// Set response header
header('Content-Type: application/json');

try {
    // Ambil data dari body request
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['orderId']) || !isset($input['status'])) {
        echo json_encode(['success' => false, 'message' => 'Data tidak lengkap.']);
        exit;
    }

    $orderId = (int)$input['orderId'];
    $status = addslashes($input['status']);

    // Inisialisasi model dan panggil fungsi updateStatus
    $modelSaleSql = new ModelSaleSql();
    $isUpdated = $modelSaleSql->updateStatus($orderId, $status);

    if ($isUpdated) {
        echo json_encode(['success' => true, 'message' => 'Status berhasil diperbarui.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui status.']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>