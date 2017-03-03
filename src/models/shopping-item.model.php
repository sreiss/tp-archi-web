<?php

include_once BASEPATH . '/models/item.model.php';

class ShoppingItem
{
    private $quantity;
    private $item_id;
    private $item;
    private $was_added;

    function __construct($quantity = 0, $item_id, $item = null, $was_added = false)
    {
        $this->quantity = $quantity;
        $this->item_id = $item_id;
        $this->item = $item;
        $this->was_added = $was_added;
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

    /**
     * @return mixed
     */
    public function was_added()
    {
        return $this->was_added;
    }

    /**
     * @param mixed $was_added
     */
    public function set_was_added($was_added)
    {
        $this->was_added = $was_added;
    }


}