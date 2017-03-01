<?php

require_once BASEPATH . '/models/item.model.php';
require_once BASEPATH . '/models/color.model.php';
require_once BASEPATH . '/models/category.model.php';
require_once BASEPATH . '/models/brand.model.php';

class Db {
    private $items;
    private $colors;
    private $categories;
    private $brands;
    private static $instance;

    private function __construct()
    {
        $this->colors = [];
        $jsonColors = json_decode(file_get_contents(BASEPATH . '/data/colors.json'));
        foreach ($jsonColors as $json) {
            array_push($this->colors, Color::deserialize($json));
        }

        $this->categories = [];
        $jsonCategories = json_decode(file_get_contents(BASEPATH . '/data/categories.json'));
        foreach ($jsonCategories as $json) {
            array_push($this->categories, Category::deserialize($json));
        }

        $this->items = [];
        $jsonItems = json_decode(file_get_contents(BASEPATH . '/data/items.json'));
        foreach ($jsonItems as $json) {
            array_push($this->items, Item::deserialize($json));
        }

        foreach ($this->items as $item) {
            $category = $this->get_category_by_id($item->get_category_id());
            foreach ($category->get_sub_categories() as $sub_category) {
                if ($sub_category->get_id() == $item->get_sub_category_id()) {
                    $sub_category->set_items_count($sub_category->get_items_count() + 1);
                }
            }
        }

        $this->brands = [];
        $jsonBrands = json_decode(file_get_contents(BASEPATH . '/data/brands.json'));
        foreach ($jsonBrands as $json) {
            array_push($this->brands, Brand::deserialize($json));
        }
    }

    public function get_categories() {
        return $this->categories;
    }

    public function get_colors() {
        return $this->colors;
    }

    public function get_brands() {
        return $this->brands;
    }

    public function get_items($join = true, $category_id = null, $sub_category_id = null, $search_text = null, $color = null) {
        $items = [];
        foreach ($this->items as $item) {
            if (!empty($category_id) && $category_id != $item->get_category_id()) {
                continue;
            }

            if (!empty($sub_category_id) && $sub_category_id != $item->get_sub_category_id()) {
                continue;
            }

            if (!empty($color) && $item->get_color() != $color) {
                continue;
            }

            if (!empty($search_text) && strpos(strtolower($item->get_name()), strtolower($search_text)) === false) {
                continue;
            }

            if ($join) {
                $item->set_category($this->get_category_by_id($item->get_category_id()));
            }

            array_push($items, $item);

        }
        return $items;
    }

    public function get_category_by_id($id) {
        foreach ($this->categories as $category) {
            if ($category->get_id() === $id) {
                return $category;
            }
        }
        throw new \Exception('Category not found');
    }

    public function get_item_by_id($id) {
        foreach ($this->items as $item) {
            if ($item->get_id() === $id) {
                return $item;
            }
        };
        throw new \Exception('Item not found');
    }

    public function item_exists($id) {
        foreach ($this->items as $item) {
            if ($item->get_id() === $id) {
                return true;
            }
        };
        return false;
    }

    public static function get_instance() {
        if (isset(self::$instance)) {
            return self::$instance;
        }
        self::$instance = new Db();
        return self::$instance;
    }
}