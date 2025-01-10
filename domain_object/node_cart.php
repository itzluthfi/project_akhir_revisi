<?php
require_once "/laragon/www/project_akhir/domain_object/node_item.php";

class Cart extends Item {
    public $id;
    public $member_id;
    public $quantity;
    public $total_price;

    // Modify constructor to inherit Item properties and initialize Cart-specific properties
    public function __construct($id, $member_id, $item_id, $item_name, $item_price, $item_stock, $item_star, $quantity) {
        // Call parent constructor to initialize item properties
        parent::__construct($item_id, $item_name, $item_price, $item_stock, $item_star);
        $this->id = $id;
        $this->member_id = $member_id;
        $this->quantity = $quantity;
        $this->total_price = $item_price * $quantity; // Calculate total price based on item price and quantity
    }

    
}