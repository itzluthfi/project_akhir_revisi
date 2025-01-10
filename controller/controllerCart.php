<?php
require_once "/laragon/www/project_akhir/model/modelCartSql.php";

class ControllerCart {
    private $modelCart;

    public function __construct() {
        $this->modelCart = new modelCart();
    }

    public function handleAction($action) {
        switch ($action) {
            case 'add':
                $member_id = $_POST['member_id'];
                $item_id = $_POST['item_id'];
                
                $quantity = $_POST['quantity'];
            

                if ($this->modelCart->addCartItem($member_id, $item_id,  $quantity)) {
                    $message = "Item berhasil ditambahkan ke keranjang!";
                } else {
                    $message = "Gagal menambahkan item ke keranjang.";
                }
                
                echo "<script>alert('$message'); window.location.href='/project_akhir/views/warkop_ui/index.php';</script>";
                break;
            

            case 'update_quantity':
                $cart_id = $_POST['cart_id'];
                $quantity = $_POST['quantity'];

                if ($this->modelCart->updateQuantity($cart_id, $quantity)) {
                    $message = "Item quantity updated successfully!";
                } else {
                    $message = "Failed to update item quantity.";
                }
                break;

            case 'remove':
                if (isset($_GET['id'])) {
                    $cart_id = $_GET['id'];
                    if ($this->modelCart->removeCartItem($cart_id)) {
                        $message = "Item removed from cart successfully!";
                    } else {
                        $message = "Failed to remove item from cart.";
                    }
                } else {
                    $message = "Item ID not provided.";
                }
                break;

            case 'checkout':
                $this->modelCart->checkout();
                $message = "Checkout successful! Your cart has been cleared.";
                break;

            default:
                $message = "Action not recognized for cart.";
                break;
        }

        // Redirect with message
        echo "<script>alert('$message'); window.location.href='/project_akhir/views/cart/cart_list.php';</script>";
    }
}