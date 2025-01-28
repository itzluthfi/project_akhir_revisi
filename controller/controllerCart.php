<?php
// require_once "../model/modelCartSql.php";

require_once __DIR__ . '../../model/modelCartSql.php';

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
                    try {
                        if (isset($_GET['id'])) {
                            $cart_id = $_GET['id'];
                
                            // Coba melakukan proses penghapusan cart berdasarkan sale ID
                            $result = $this->modelCart->deleteCartsBySaleId($cart_id);
                
                            if ($result === true) {
                                $message = "Checkout berhasil dilakukan! Keranjang berhasil dihapus.";
                            } else {
                                // Jika hasil bukan true, anggap sebagai error
                                throw new Exception("Gagal melakukan checkout. Error: $result");
                            }
                        } else {
                            // Jika ID tidak diberikan
                            throw new Exception("tidak ada ID cart yang diberikan");
                        }
                    } catch (Exception $e) {
                        // Tangkap exception dan simpan pesan error
                        $message = $e->getMessage();
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