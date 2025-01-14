<?php
require_once "../model/modelCartSql.php";

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
            
                $result = $this->modelCart->addCartItem($member_id, $item_id, $quantity);
            
                if ($result === true) {
                    $message = "Item berhasil ditambahkan ke keranjang!";
                } else {
                    $message = "Gagal menambahkan item ke keranjang. Error: $result";
                }
                
                echo "<script>alert('$message'); window.location.href='./views/warkop_ui/index.php';</script>";
                break;
            
            case 'update_quantity':
                $cart_id = $_POST['cart_id'];
                $quantity = $_POST['quantity'];
            
                $result = $this->modelCart->updateQuantity($cart_id, $quantity);
            
                if ($result === true) {
                    $message = "Item quantity updated successfully!";
                } else {
                    $message = "Failed to update item quantity. Error: $result";
                }
            
                echo "<script>alert('$message'); window.location.href='./views/cart/cart_list.php';</script>";
                break;
            
            case 'delete':
                if (isset($_GET['id'])) {
                    $cart_id = $_GET['id'];
                    $result = $this->modelCart->removeCartItem($cart_id);
            
                    if ($result === true) {
                        $message = "Item removed from cart successfully!";
                    } else {
                        $message = "Failed to remove item from cart. Error: $result";
                    }
                } else {
                    $message = "Item ID not provided.";
                }
            
                echo "<script>alert('$message'); window.location.href='./views/cart/cart_list.php';</script>";
                break;

                case 'checkout':
                    if (isset($_GET['id'])) {
                        $cart_id = $_GET['id'];
                        $result = $this->modelCart->deleteCartsBySaleId($cart_id);
                
                        if ($result === true) {
                            $message = "Checkout successful! Your cart has been cleared.";
                        } else {
                            $message = "Failed to checkout. Error: $result"; 
                        }
                    } else {
                        $message = "Cart ID not provided for checkout.";
                    }
                
                    // Redirect dengan pesan
                    echo "<script>alert('$message'); window.location.href='./views/warkop_ui/index.php';</script>";
                    break;
                

            default:
                $message = "Action not recognized for cart.";
                break;
        }

        // Redirect with message
        echo "<script>alert('$message'); window.location.href='./views/cart/cart_list.php';</script>";
    }
}