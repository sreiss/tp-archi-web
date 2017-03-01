<?php

include_once BASEPATH . '/models/item.model.php';

class ShoppingItem
{
    private $quantity;
    private $item_id;
    private $item;

    function __construct($quantity = 0, $item_id, $item = null)
    {
        $this->quantity = $quantity;
        $this->item_id = $item_id;
        $this->item = $item;
    }

    public function compute_subtotal() {
        return $this->item->get_price() * $this->quantity;
    }

    public function increment_quantity() {
        $this->quantity += 1;
    }

    public function prepare_for_save() {
        unset($this->item);
    }

    /**
     * @return int
     */
    public function get_quantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function set_quantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function get_item_id()
    {
        return $this->item_id;
    }

    /**
     * @return mixed
     */
    public function get_item()
    {
        return $this->item;
    }

    public function set_item(Item $item)
    {
        $this->item = $item;
    }
}