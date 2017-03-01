<?php

class ShoppingCart {
    private static $instance;

    private function __construct() {
    }

    public static function get_instance() {
        if (isset(self::$instance)) {
            return self::$instance;
        }
        self::$instance = new ShoppingCart();
        return self::$instance;
    }

    public function exists_in_cart($id) {
        $cart = $this->get_cart();
        foreach ($cart as $in_cart_item) {
            if ($in_cart_item->get_item_id() === $id) {
                return true;
                break;
            }
        }
        return false;
    }

    public function get_cart($join_item = false) {
        if (!isset($_SESSION['shopping_items'])) {
            $_SESSION['shopping_items'] = [];
        }

        $cart = $_SESSION['shopping_items'];
        if ($join_item) {
            foreach ($cart as $shopping_item) {
                $item = Db::get_instance()->get_item_by_id($shopping_item->get_item_id());
                $shopping_item->set_item($item);
            }
        }

        return $cart;
    }

    public function add_to_cart($shopping_item) {
        array_push($_SESSION['shopping_items'], $shopping_item);
    }

    public function save_cart($shopping_cart) {
        $shopping_cart = array_map(function($item) {
            $item->prepare_for_save();
            return $item;
        }, $shopping_cart);
        $_SESSION['shopping_items'] = $shopping_cart;
    }

    public function compute_grand_total() {
        $total = 0;
        $cart = $this->get_cart();
        foreach ($cart as $shopping_item) {
            $total += $shopping_item->compute_subtotal();
        }
        return $total;
    }

    /**
     * Returns the count of shopping items in the cart.
     * @return int
     */
    public function count_items_in_cart() {
        return count($this->get_cart());
    }
}