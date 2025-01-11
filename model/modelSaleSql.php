<?php

// require_once "/laragon/www/project_akhir/model/dbConnect.php";
// require_once "/laragon/www/project_akhir/domain_object/node_sale.php";
// require_once "/laragon/www/project_akhir/domain_object/node_detailSale.php";

require_once __DIR__ . '/dbConnectNew.php';
require_once __DIR__ . '../../domain_object/node_sale.php';
require_once __DIR__ . '../../domain_object/node_detailSale.php';



class ModelSaleSql {
    private $db;

    public function __construct() {
        // Inisialisasi koneksi database
        $this->db = Databases::getInstance();
        // $this->initializeDefaultItems(); // Anda bisa menambahkan ini jika ingin menambahkan item default saat pertama kali  
    }

    public function addSale($detailSale, int $salePay, int $saleChange, int $saleTotalPrice, $saleDate, int $user_id,  $member_id) {
        $salePay = (int)$salePay;
        $saleChange = (int)$saleChange;
        $saleTotalPrice = (int)$saleTotalPrice;
        $saleDate = addslashes($saleDate); // Escape string input
        $user_id = (int)$user_id;
        $member_id = (int)$member_id;
    
        
        $query = "INSERT INTO sales (user_id, member_id, pay, `change`, total_price, date) 
                  VALUES ($user_id, $member_id, $salePay, $saleChange, $saleTotalPrice, '$saleDate')";
    
        try {
            $this->db->execute($query);
            $saleId = $this->db->conn->insert_id;
    
            $detailsalesData = [];
            if (!empty($detailSale) ) {
                foreach ($detailSale as $index => $item) {
                    echo "<script>console.log('Processing item at index $index: " . json_encode($item) . "');</script>";
    
                    // Validate and process each item
                    $item_id = isset($item['item_id']) && $item['item_id'] !== '' ? (int)$item['item_id'] : null;
                    $quantity = isset($item['item_qty']) && $item['item_qty'] !== '' ? (int)$item['item_qty'] : null;
    
                    if ($item_id !== null && $quantity !== null) {
                        $detailQuery = "INSERT INTO detailsales (id, sale_id, item_id, quantity) 
                                        VALUES (NULL, $saleId, $item_id, $quantity)";
                        $this->db->execute($detailQuery);
    
                        $detailsalesData[] = [
                            'sale_id' => $saleId,
                            'item_id' => $item_id,
                            'quantity' => $quantity,
                        ];
                    } else {
                        echo "<script>console.log('Skipping invalid item data at index $index');</script>";
                    }
                }
            } else {
                echo "<script>console.log('detailSale is empty or not an array');</script>";
            }
    

    
            return true;
        } catch (Exception $e) {
            $errorMessage = addslashes($e->getMessage());
            echo "<script>console.log('Error adding sale: $errorMessage');</script>";
            return false;
        }
    }
    

    public function addMitransSale($detailSale, int $saleTotalPrice, $saleDate, int $user_id, int $member_id, string $status) {
        $saleTotalPrice = (int)$saleTotalPrice;
        $saleDate = addslashes($saleDate); // Escape string input
        $user_id = (int)$user_id;
        $member_id = (int)$member_id;
        $status = addslashes($status); // Escape string input for status
    
        $query = "INSERT INTO sales_midtrans (user_id, member_id, total_price, status, date) 
                  VALUES ($user_id, $member_id, $saleTotalPrice, '$status', '$saleDate')";
    
        try {
            $this->db->execute($query);
            $saleId = $this->db->conn->insert_id;

            $detailsalesData = [];
            if (!empty($detailSale)) {
                foreach ($detailSale as $index => $item) {
                    // Validate and process each item
                    $item_id = isset($item['item_id']) && $item['item_id'] !== '' ? (int)$item['item_id'] : null;
                    $quantity = isset($item['item_qty']) && $item['item_qty'] !== '' ? (int)$item['item_qty'] : null;
    
                    if ($item_id !== null && $quantity !== null) {
                        $detailQuery = "INSERT INTO detailsales (id, sale_id, item_id, quantity) 
                                        VALUES (NULL, $saleId, $item_id, $quantity)";
                        $this->db->execute($detailQuery);
    
                        $detailsalesData[] = [
                            'sale_id' => $saleId,
                            'item_id' => $item_id,
                            'quantity' => $quantity,
                        ];
                    }
                }
            }
    
            return $saleId;
        } catch (Exception $e) {
            $errorMessage = addslashes($e->getMessage());
            echo "<script>console.log('Error adding Midtrans sale: $errorMessage');</script>";
            return false;
        }
    }
    
     

    
    
    

    public function getAllSalesMidtrans() {
        $query = "SELECT * FROM sales_midtrans";
        $result = $this->db->select($query);
        // $sale_status = "settlement";
        $sales = [];
        foreach ($result as $row) {
            $saleId = $row['id'];
            $details = $this->getDetailsBySaleId($saleId);
            $sales[] = new Sale($saleId, 0, 0, $row['total_price'],$row['status'], $row['date'], $row['user_id'], $row['member_id'], $details);
        }
        return $sales;
    }

    public function getAllSales() {
        $query = "SELECT * FROM sales";
        $result = $this->db->select($query);
        $sale_status = "settlement";
        $sales = [];
        foreach ($result as $row) {
            $saleId = $row['id'];
            $details = $this->getDetailsBySaleId($saleId);
            $sales[] = new Sale($saleId, $row['pay'], $row['change'], $row['total_price'],$sale_status, $row['date'], $row['user_id'], $row['member_id'], $details);
        }
        return $sales;
    }

    private function getDetailsBySaleId($saleId) {
        $query = "SELECT * FROM detailsales WHERE sale_id = $saleId";
        $result = $this->db->select($query);

        $details = [];
        foreach ($result as $row) {
            $details[] = new DetailSale($row['sale_id'], $row['item_id'], '', 0, $row['quantity']); // Tidak ada nama item & harga
        }
        return $details;
    }

    public function getSaleById($saleId) {
        $saleId = (int)$saleId;
        $query = "SELECT * FROM sales WHERE id = $saleId";
        $result = $this->db->select($query);
        $sale_status = "settlement";

        if (count($result) > 0) {
            $row = $result[0];
            $details = $this->getDetailsBySaleId($saleId);
        return new Sale($row['id'], $row['pay'], $row['change'], $row['total_price'],$sale_status, $row['date'], $row['user_id'], $row['member_id'], $details);
        }

        return null;
    }

    public function deleteSale($saleId) {
        $saleId = (int)$saleId;

        // Hapus detail sales terlebih dahulu
        $detailQuery = "DELETE FROM detailsales WHERE sale_id = $saleId";

        try {
            $this->db->execute($detailQuery);

            // Hapus data dari tabel sales
            $query = "DELETE FROM sales WHERE id = $saleId";
            $this->db->execute($query);

            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error deleting sale: " . addslashes($e->getMessage()) . "');</script>";
            return false;
        }
    }

    public function __destruct() {
        // Menutup koneksi database
        $this->db->close();
    }
}

?>