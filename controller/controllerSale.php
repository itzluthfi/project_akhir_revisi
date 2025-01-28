<?php

require_once __DIR__ . '../../model/modelSaleSql.php';

class ControllerSale {
    private $modelSale;

    public function __construct() {
        $this->modelSale = new ModelSaleSql();
    }

    public function handleAction($action) {
        switch ($action) {

            case 'add':
                // Validasi data POST
                if (
                    isset($_POST['sale_pay'], $_POST['sale_change'], $_POST['sale_totalPrice'], $_POST['items'], $_POST['id_user'], $_POST['id_member'])
                ) {
                    $sale_date = date('Y-m-d');
                    $sale_pay = intval($_POST['sale_pay']);
                    $sale_change = intval($_POST['sale_change']);
                    $sale_totalPrice = intval($_POST['sale_totalPrice']);
                    $id_user = intval($_POST['id_user']);
                    $id_member = intval($_POST['id_member']);
            
                    // Validasi nilai-nilai penting
                    if ($sale_pay <= 0 || $sale_totalPrice <= 0) {
                        echo "<script>alert('Total harga atau pembayaran tidak valid!'); window.history.back();</script>";
                        break;
                    }
            
                    // Ambil dan validasi data items
                    $itemsData = json_decode($_POST['items'], true);
                    if (json_last_error() !== JSON_ERROR_NONE || !is_array($itemsData) || empty($itemsData)) {
                        echo "<script>alert('Data items tidak valid!'); window.history.back();</script>";
                        break;
                    }
            
                    foreach ($itemsData as $item) {
                        if (!isset($item['item_id'], $item['item_qty']) || $item['item_qty'] <= 0) {
                            echo "<script>alert('Data item tidak lengkap atau tidak valid!'); window.history.back();</script>";
                            break 2;
                        }
                    }
            
                    // Tambahkan penjualan dan detailnya
                    $isSuccess = $this->modelSale->addSale($itemsData, $sale_pay, $sale_change, $sale_totalPrice, $sale_date, $id_user, $id_member);
            
                    if ($isSuccess) {
                        echo "<script>alert('Penjualan berhasil ditambahkan!'); window.location.href='./views/sale/sale_list.php';</script>";
                    } else {
                        echo "<script>alert('Gagal menambahkan penjualan!'); window.history.back();</script>";
                    }
                } else {
                    echo "<script>alert('Data yang dikirim tidak lengkap!'); window.history.back();</script>";
                }
                break;

            // case 'checkout':
                
                

            case 'delete':
                // Menghapus penjualan berdasarkan ID
                if (isset($_GET['id'])) {
                    $saleId = intval($_GET['id']);
                    if ($this->modelSale->deleteSale($saleId)) {
                        echo "<script>alert('Penjualan berhasil dihapus!'); window.location.href='./views/sale/sale_list.php';</script>";
                    } else {
                        echo "<script>alert('Gagal menghapus penjualan!'); window.location.href='./views/sale/sale_list.php';</script>";
                    }
                } else {
                    echo "<script>alert('ID penjualan tidak ditemukan!'); window.history.back();</script>";
                }
                break;

            default:
                echo "<script>alert('Aksi tidak dikenal!'); window.location.href='./views/sale/sale_list.php';</script>";
                break;
        }
    }
}
?>