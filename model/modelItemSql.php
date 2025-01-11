<?php


require_once __DIR__ . '/dbConnectNew.php';
require_once __DIR__ . '/../domain_object/node_item.php';


class modelItem {
    private $db;

    public function __construct() {
        // Inisialisasi koneksi database
        $this->db = Databases::getInstance();
        $this->initializeDefaultItems(); // Anda bisa menambahkan ini jika ingin menambahkan item default saat pertama kali

        
    }

    public function initializeDefaultItems() {
        // Cek apakah tabel kosong, jika ya, tambahkan item default
        $items = $this->getAllItem();
        if (count($items) === 0) {
            $this->addItem("Latte", 10000, 20, 4);
            $this->addItem("Expresso", 8000, 17, 5);
            $this->addItem("Caramel", 12000, 14, 0);
            $this->addItem("Gula-Aren", 11000, 14, 5);
            $this->addItem("Mocha", 14000, 14, 3);
            $this->addItem("Cappuccino", 15000, 14, 5);
        }
    }

    public function addItem($item_name, $item_price, $item_stock, $item_star) {
        // Escape input untuk mencegah SQL Injection
        $item_name = mysqli_real_escape_string($this->db->conn, $item_name);
        $item_price = (int)$item_price;
        $item_stock = (int)$item_stock;
        $item_star = (int)$item_star;

        $query = "INSERT INTO items (name, price, stock, star) VALUES ('$item_name', $item_price, $item_stock, $item_star)";
        try {
            $this->db->execute($query);
            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error adding item: " . $e->getMessage() . "');</script>";
            return false;
        }
    }

    public function getAllItem() {
        $query = "SELECT * FROM items";
        $result = $this->db->select($query);
        
        $items = [];
        foreach ($result as $row) {
            $items[] = new Item($row['id'], $row['name'], $row['price'], $row['stock'], $row['star']);
        }

        // Debugging message
        echo "<script>console.log('Fetched items from database: " . json_encode($items) . "');</script>";

        return $items;
    }

    public function getItemById($id) {
        $id = (int)$id;
        $query = "SELECT * FROM items WHERE id = $id";
        $result = $this->db->select($query);

        if (count($result) > 0) {
            $row = $result[0];
            // Debugging message
            echo "<script>console.log('Item found by ID: " . json_encode($row) . "');</script>";
            return new Item($row['id'], $row['name'], $row['price'], $row['stock'], $row['star']);
        }

        // Debugging message
        echo "<script>console.log('No item found for ID: $id');</script>";
        return null;
    }

    public function updateItem($id, $item_name, $item_price, $item_stock, $item_star) {
        $id = (int)$id;
        $item_name = mysqli_real_escape_string($this->db->conn, $item_name);
        $item_price = (int)$item_price;
        $item_stock = (int)$item_stock;
        $item_star = (int)$item_star;

        $query = "UPDATE items SET name = '$item_name', price = $item_price, stock = $item_stock, star = $item_star WHERE id = $id";
        try {
            $this->db->execute($query);
            // Debugging message
            echo "<script>console.log('Updated item with ID: $id');</script>";
            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error updating item: " . $e->getMessage() . "');</script>";
            return false;
        }
    }

    public function deleteItem($id) {
        $id = (int)$id;
        $query = "DELETE FROM items WHERE id = $id";
        try {
            $this->db->execute($query);
            // Debugging message
            echo "<script>console.log('Deleted item with ID: $id');</script>";
            return true;
        } catch (Exception $e) {
            echo "<script>console.log('Error deleting item: " . $e->getMessage() . "');</script>";
            return false;
        }
    }

    public function __destruct() {
        // Menutup koneksi database
        $this->db->close();
    }
}
?>