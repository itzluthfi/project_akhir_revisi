<!-- <?php

require_once "/laragon/www/project_akhir/domain_object/node_cart.php";

class modelCart {
    private $carts = [];
    private $nextId = 1;

    public function __construct() {
        if (isset($_SESSION['carts'])) {
            $this->carts = unserialize($_SESSION['carts']);
            $this->nextId = isset($_SESSION['lastCartId']) ? $_SESSION['lastCartId'] + 1 : 1;
        } else {
            $this->initializeDefaultCartItems();
            $this->nextId = count($this->carts) + 1; 
        }
    }

    public function initializeDefaultCartItems() {
        // member_id,item_id,item_name,item_price,item_stock,item_star,quantity
        $this->addCartItem(1, 6, "Cappuccino", 25000, 10, 4.5, 2);
        $this->addCartItem(1, 3, "Caramel", 30000, 5, 4.0, 1);
        $this->addCartItem(1, 1, "Latte", 15000, 8, 3.8, 3);
        $this->addCartItem(1, 4, "Gula-Aren", 15000, 8, 3.8, 3);
        $this->addCartItem(2, 4, "Gula-Aren", 25000, 10, 4.5, 2);
        $this->addCartItem(2, 5, "Mocha", 30000, 5, 4.0, 1);
        $this->addCartItem(2, 2, "Expresso", 15000, 8, 3.8, 3);
    }

    public function addCartItem($member_id, $item_id, $item_name, $item_price, $item_stock, $item_star, $quantity) {
        // Cari cart yang ada dengan item_id dan member_id yang sama
        $existingCart = $this->getCartItemByItemAndMemberId($item_id, $member_id);
    
        if ($existingCart) {
            // Jika item sudah ada dalam cart dengan member_id yang sama, update quantity
            $this->updateQuantity($existingCart->id, $existingCart->quantity + $quantity);
        } else {
            // Jika tidak, buat item keranjang baru
            $cart = new Cart($this->nextId, $member_id, $item_id, $item_name, $item_price, $item_stock, $item_star, $quantity);
            $this->carts[] = $cart;
            $_SESSION['lastCartId'] = $this->nextId; 
            $this->nextId++;  
        }
    
        $this->saveToSession();
        return true;
    }
    
    // Fungsi untuk mendapatkan item cart berdasarkan item_id dan member_id
    public function getCartItemByItemAndMemberId($item_id, $member_id) {
        foreach ($this->carts as $cart) {
            if ($cart->item_id == $item_id && $cart->member_id == $member_id) {
                return $cart;
            }
        }
        return null;
    }
    
    // Update quantity and total price for a specific cart item
    public function updateQuantity($cartId, $new_quantity) {
        $cart = $this->getCartItemById($cartId);
        if ($cart) {
            $cart->quantity = $new_quantity;
            $cart->total_price = $cart->item_price * $new_quantity;
            $this->saveToSession();
            return true;
        }
        return false;
    }

    private function saveToSession() {
        $_SESSION['carts'] = serialize($this->carts);
    }

    public function getAllCartItems() {
        return $this->carts;
    }

    // Get cart items by member_id
    public function getCartsByMemberId($member_id) {
        $memberCarts = [];
        foreach ($this->carts as $cart) {
            if ($cart->member_id == $member_id) {
                $memberCarts[] = $cart;
            }
        }
        return $memberCarts;
    }

    public function getCartItemById($id) {
        foreach ($this->carts as $cart) {
            if ($cart->id == $id) {
                return $cart;
            }
        }
        return null;
    }

    public function getCartItemByItemId($item_id) {
        foreach ($this->carts as $cart) {
            if ($cart->item_id == $item_id) {
                return $cart;
            }
        }
        return null;
    }

    public function updateCartItemQuantity($id, $quantity) {
        return $this->updateQuantity($id, $quantity);
    }

    public function removeCartItem($id) {
        foreach ($this->carts as $key => $cart) {
            if ($cart->id == $id) {
                unset($this->carts[$key]);
                $this->carts = array_values($this->carts);
                $this->saveToSession();
                return true;
            }
        }
        return false;
    }

    public function getTotalPrice() {
        $total = 0;
        foreach ($this->carts as $cart) {
            $total += $cart->total_price;
        }
        return $total;
    }

    public function checkout() {
        // Hapus semua item dari keranjang
        $this->carts = [];
        $this->saveToSession();
    }
}



?> -->