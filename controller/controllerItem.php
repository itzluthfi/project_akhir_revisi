<?php
require_once __DIR__ . '../../model/modelItemSql.php';

class ControllerItem {
    private $modelItem;

    public function __construct() {
        $this->modelItem = new modelItem();
    }

    public function handleAction($action) {
        switch ($action) {
            case 'add':
                $item_name = $_POST['item_name'] ?? null;
                $item_price = $_POST['item_price'] ?? null;
                $item_stock = $_POST['item_stock'] ?? null;
                $item_star = $_POST['item_star'] ?? null;

                if (!$item_name || !$item_price || !$item_stock || !$item_star) {
                    $message = "All fields are required to add an item.";
                } else {
                    $result = $this->modelItem->addItem($item_name, $item_price, $item_stock, $item_star);
                    $message = $result === true
                        ? "Item successfully added!"
                        : "Failed to add item. Error: $result";
                }

                echo "<script>alert('$message'); window.location.href='./views/item/item_list.php';</script>";
                break;

            case 'update':
                $item_id = $_POST['item_id'] ?? null;
                $item_name = $_POST['item_name'] ?? null;
                $item_price = $_POST['item_price'] ?? null;
                $item_stock = $_POST['item_stock'] ?? null;
                $item_star = $_POST['item_star'] ?? null;

                if (!$item_id || !$item_name || !$item_price || !$item_stock || !$item_star) {
                    $message = "All fields are required to update an item.";
                } else {
                    $result = $this->modelItem->updateItem($item_id, $item_name, $item_price, $item_stock, $item_star);
                    $message = $result === true
                        ? "Item successfully updated!"
                        : "Failed to update item. Error: $result";
                }

                echo "<script>alert('$message'); window.location.href='./views/item/item_list.php';</script>";
                break;

            case 'delete':
                $item_id = $_GET['id'] ?? null;

                if (!$item_id) {
                    $message = "Item ID not provided for deletion.";
                } else {
                    $result = $this->modelItem->deleteItem($item_id);
                    $message = $result === true
                        ? "Item successfully deleted!"
                        : "Failed to delete item. Error: $result";
                }

                echo "<script>alert('$message'); window.location.href='./views/item/item_list.php';</script>";
                break;

            case 'getItemById':
                $item_id = $_GET['id'] ?? null;

                if (!$item_id) {
                    echo json_encode(['error' => 'Item ID not provided']);
                } else {
                    $item = $this->modelItem->getItemById($item_id);
                    echo $item ? json_encode($item) : json_encode(['error' => 'Item not found']);
                }
                break;

            default:
                $message = "Action not recognized for item.";
                echo "<script>alert('$message'); window.location.href='./views/item/item_list.php';</script>";
                break;
        }
    }
}