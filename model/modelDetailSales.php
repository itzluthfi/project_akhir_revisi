<?php

require_once __DIR__ . '../../domain_object/node_detailSales.php';
require_once __DIR__ . '../../config/dbConnectNew.php';


class modelDetailSale {
    private $db;

    public function __construct() {
        // Inisialisasi koneksi database
        $this->db = Databases::getInstance();

        
    }

    // Menambahkan detail sale baru
    public function addDetailSale($sale_id, $item_id, $quantity) {
        $sale_id = (int) $sale_id;
        $item_id = (int) $item_id;
        $quantity = (int) $quantity;

        $query = "INSERT INTO detailsales (sale_id, item_id, quantity) VALUES ($sale_id, $item_id, $quantity)";
        try {
            $this->db->execute($query);
            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error adding detail sale: " . $e->getMessage() . "');</script>";
            return false;
        }
    }

    // Mengambil semua detail sale berdasarkan sale_id
    public function getDetailSalesBySaleId($sale_id) {
        $sale_id = (int) $sale_id;

        $query = "SELECT * FROM detailsales WHERE sale_id = $sale_id";
        $result = $this->db->select($query);

        $detailSales = [];
        foreach ($result as $row) {
            // Membuat objek DetailSale dan menambahkannya ke array
            $detailSales[] = new DetailSales($row['id'], $row['sale_id'], $row['item_id'], $row['quantity']);
        }

        return $detailSales;
    }

    // Mengambil detail sale berdasarkan ID
    public function getDetailSaleById($id) {
        $query = "SELECT * FROM detailsales WHERE id = $id";
        $result = $this->db->select($query);

        if (count($result) > 0) {
            $row = $result[0];
            return new DetailSales($row['id'], $row['sale_id'], $row['item_id'], $row['quantity']);
        }

        return null;
    }

    // Memperbarui detail sale
    public function updateDetailSale($id, $sale_id, $item_id, $quantity) {
        $sale_id = (int) $sale_id;
        $item_id = (int) $item_id;
        $quantity = (int) $quantity;

        $query = "UPDATE detailsales SET sale_id = $sale_id, item_id = $item_id, quantity = $quantity WHERE id = $id";
        try {
            $this->db->execute($query);
            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error updating detail sale: " . $e->getMessage() . "');</script>";
            return false;
        }
    }

    // Menghapus detail sale
    public function deleteDetailSale($id) {
        $query = "DELETE FROM detailsales WHERE id = $id";
        try {
            $this->db->execute($query);
            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error deleting detail sale: " . $e->getMessage() . "');</script>";
            return false;
        }
    }
}

?>