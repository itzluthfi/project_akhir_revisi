<?php
require_once __DIR__ . '/node_item.php';
class DetailSale extends Item{
    public $id_sale;
    public $item_qty; 
    public $subtotal;

    public function __construct( $id_sale, $item_id , $item_name,  $item_price,  $item_qty) {
        $this->id_sale = $id_sale;
        $this->item_id = $item_id;
        $this->item_name = $item_name;
        $this->item_price = $item_price;
        $this->item_qty = $item_qty;
        $this->subtotal = $item_price * $item_qty;
    }
}