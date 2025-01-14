<?php

require_once __DIR__ . '../../config/dbConnectNew.php';
require_once __DIR__ . '../../domain_object/node_cart.php';

class modelCart {
    private $db;
    private $carts = [];

    public function __construct() {
        // Gunakan koneksi database global
        $this->db = Databases::getInstance();
        // Ambil data dari database
        $this->carts = $this->getAllCartItemsFromDB();
    }

    public function addCartItem($member_id, $item_id, $quantity) {
        $existingCart = $this->getCartItemByItemAndMemberId($item_id, $member_id);

        if ($existingCart) {
            // Update quantity jika item sudah ada
            $newQuantity = $existingCart->quantity + $quantity;
            return $this->updateQuantity($existingCart->id, $newQuantity);
        } else {
            // Tambahkan item baru ke keranjang
            $query = "INSERT INTO carts (member_id, item_id, quantity) VALUES ('$member_id', '$item_id', '$quantity')";
            try {
                $this->db->execute($query);
                // Perbarui data dari database
                $this->carts = $this->getAllCartItemsFromDB();
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    private function getAllCartItemsFromDB() {
        $query = "SELECT * FROM carts";
        $result = $this->db->select($query);

        $carts = [];
        foreach ($result as $row) {
            // Cari data item terkait berdasarkan item_id
            $itemQuery = "SELECT * FROM items WHERE id = " . $row['item_id'];
            $itemResult = $this->db->select($itemQuery);

            if (count($itemResult) > 0) {
                $item = $itemResult[0];

                $carts[] = new Cart(
                    $row['id'],
                    $row['member_id'],
                    $item['id'],
                    $item['name'],
                    $item['price'],
                    $item['stock'],
                    $item['star'],
                    $row['quantity']
                );
            }
        }
        return $carts;
    }

    public function getCartsByMemberId($member_id) {
        $query = "SELECT * FROM carts WHERE member_id = $member_id";
        $result = $this->db->select($query);

        $carts = [];
        foreach ($result as $row) {
            // Fetch item details from items table
            $itemQuery = "SELECT * FROM items WHERE id = {$row['item_id']}";
            $itemResult = $this->db->select($itemQuery);

            if (count($itemResult) > 0) {
                $item = $itemResult[0];
                $carts[] = new Cart(
                    $row['id'],
                    $row['member_id'],
                    $item['id'],
                    $item['name'],
                    $item['price'],
                    $item['stock'],
                    $item['star'],
                    $row['quantity']
                );
            }
        }
        return $carts;
    }

    public function getCartItemByItemAndMemberId($item_id, $member_id) {
        foreach ($this->carts as $cart) {
            if ($cart->item_id == $item_id && $cart->member_id == $member_id) {
                return $cart;
            }
        }
        return null;
    }

    public function updateQuantity($cartId, $new_quantity) {
        $query = "UPDATE carts SET quantity = $new_quantity WHERE id = $cartId";
        try {
            $this->db->execute($query);
            // Perbarui data dari database
            $this->carts = $this->getAllCartItemsFromDB();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getAllCartItems() {
        return $this->carts;
    }

    public function removeCartItem($id) {
        $query = "DELETE FROM carts WHERE id = $id";
        try {
            $this->db->execute($query);
            // Perbarui data dari database
            $this->carts = $this->getAllCartItemsFromDB();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteCartsBySaleId($sale_id) {
        $query = "DELETE FROM carts WHERE sale_id = $sale_id";
        try {
            $this->db->execute($query);
            // Perbarui data dari database
            $this->carts = $this->getAllCartItemsFromDB();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


}

?>