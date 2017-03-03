<?php

include_once BASEPATH . '/data/shopping-cart.mock.php';

class BaseController
{
    protected function render($template_name, $vars) {
        $vars['shopping_items_count'] = ShoppingCart::get_instance()->count_items_in_cart();
        $vars['script_file'] = PageConfig::get_instance()->get_script_file();

        include_once BASEPATH . '/templates/base.php';
        include_once BASEPATH . '/templates/' . $template_name;
    }
}