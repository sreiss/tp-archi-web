<?php

include 'base.controller.php';
include_once BASEPATH . '/models/breadcrumb.model.php';
include_once BASEPATH . '/models/shopping-item.model.php';
include_once BASEPATH . '/data/db.mock.php';
include_once BASEPATH . '/data/shopping-cart.mock.php';

class ShoppingCartController extends BaseController
{
    /**
     * Displays the shopping cart page.
     */
    public function index() {
        $shopping_items = ShoppingCart::get_instance()->get_cart(true);
        $total = ShoppingCart::get_instance()->compute_grand_total();

        $this->render('shopping-cart.php', [
            'page_title' => 'Shopping Cart',
            'breadcrumbs' => [
                new Breadcrumb('Home', BASEURL),
                new Breadcrumb('Shopping cart', HOST . '/shopping-cart', true)
            ],
            'shopping_cart' => $shopping_items,
            'grand_total' => $total,
            'subtotal' => $total
        ]);
    }

    /**
     * Removes an item from the shopping cart, by giving the id of the contained item (e.g.: $shoppingItem->item_id).
     * @param $id int The id of the item.
     * @throws Error
     */
    public function remove_from_cart($id) {
        if (isset($id) && $id = ((int) $id)) {
            foreach ($_SESSION['shopping_items'] as $i => $item) {
                if ($_SESSION['shopping_items'][$i]->get_item_id() == $id) {
                    unset($_SESSION['shopping_items'][$i]);
                }
            }
            echo json_encode(['shoppingItemsCount' => ShoppingCart::get_instance()->count_items_in_cart()]);
        } else {
            throw new Error('Invalid id');
        }
        exit;
    }

    /**
     * Updates a shopping item in the cart by giving the contained item id (e.g.: $shoppingItem->item_id).
     * @param $id int The id of the item.
     * @throws Error
     */
    public function update_in_cart($id) {
        if (ShoppingCart::get_instance()->count_items_in_cart() == 0) {
            throw new Error('Cart is empty');
        }

        $id = (int) $id;

        json_decode(parse_str(file_get_contents("php://input"), $updates));

        $cart = ShoppingCart::get_instance()->get_cart();
        $this->update_quantity($cart, $id, $updates);

        ShoppingCart::get_instance()->save_cart($cart);
        exit;
    }

    /**
     * Adds an item to the cart. If the item already exists, increments it's quantity.
     * The item id must be passed in the body of the httpRequest in a plain javascript Object.
     * @throws Error
     */
    public function add_to_cart() {
        json_decode(parse_str(file_get_contents("php://input"), $data));
        if (isset($data) && isset($data["id"]) && $id = ((int) $data["id"])) {
            // ADD TO CART
            $item_exists = Db::get_instance()->item_exists($id);
            if (!$item_exists) {
                http_response_code(404);
                echo 'Item not found.';
                return;
            }

            if (!ShoppingCart::get_instance()->exists_in_cart($id)) {
                $shopping_item = new ShoppingItem(1, $id);
                ShoppingCart::get_instance()->add_to_cart($shopping_item);
            } else {
                $cart = ShoppingCart::get_instance()->get_cart();
                $this->update_quantity($cart, $id);
            }

            header('Content-Type: application/json');
            echo json_encode([
                'shoppingItemsCount' => ShoppingCart::get_instance()->count_items_in_cart(),
                'addedItem' => Db::get_instance()->get_item_by_id($id)
            ]);

        } else {
            throw new Error('Invalid id');
        }
        exit;
    }

    // Helpers

    private function update_quantity($cart, $id, $updates = null) {
        foreach ($cart as $in_cart_item) {
            if ($in_cart_item->get_item_id() === $id) {
                if (!empty($updates)) {
                    if (isset($updates['quantity']) && $quantity = ((int)$updates['quantity'])) {
                        $in_cart_item->set_quantity(abs($quantity));
                    }
                } else {
                    $in_cart_item->set_quantity($in_cart_item->get_quantity() + 1);
                }
                break;
            }
        }
    }

}