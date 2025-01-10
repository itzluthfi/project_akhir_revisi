<?php
require_once "/laragon/www/project_akhir/model/modelItemSql.php";

class ControllerItem {
    private $modelItem;

    public function __construct() {
        $this->modelItem = new modelItem();
    }

    public function handleAction($action) {
        switch ($action) {
            case 'add':
                $item_name = $_POST['item_name'];
                $item_price = $_POST['item_price'];
                $item_stock = $_POST['item_stock'];
                $item_star = $_POST['item_star'];
                if($this->modelItem->addItem($item_name, $item_price, $item_stock,$item_star)){

                    $message = "Item added successfully!";
                }else{
                    $message = "Failed to Add item22.";

                }
                break;

            case 'update':
                $item_id = $_POST['item_id'];
                $item_name = $_POST['item_name'];
                $item_price = $_POST['item_price'];
                $item_stock = $_POST['item_stock'];
                $item_star = $_POST['item_star'];
                if ($this->modelItem->updateItem($item_id, $item_name,$item_price, $item_stock,$item_star)) {
                    $message = "Item updated successfully!";
                } else {
                    $message = "Failed to update item.";
                }
                break;

            case 'delete':
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    if ($this->modelItem->deleteItem($id)) {
                        $message = "Item deleted successfully!";
                    } else {
                        $message = "Failed to delete item." . $id;
                    }
                } else {
                    $message = "Item ID not provided.";
                }
                break;

                case 'getItemById':
                    if (isset($_GET['id'])) {
                        $item = $this->modelItem->getItemById($_GET['id']);
                        if ($item) {
                            echo json_encode($item);  // Kembalikan item dalam format JSON
                        } else {
                            echo json_encode(['error' => 'Item not found']);
                        }
                    } else {
                        echo json_encode(['error' => 'Item ID not provided']);
                    }
                    break;

            default:
                $message = "Action not recognized for item.";
                break;
        }

        // Redirect after action
        echo "<script>alert('$message'); window.location.href='/project_akhir/views/item/item_list.php';</script>";
    }
}