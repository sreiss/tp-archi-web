<?php

include 'base.controller.php';

include BASEPATH . '/models/breadcrumb.model.php';
include BASEPATH . '/data/db.mock.php';

class DesignController extends BaseController {

    public function index($params = null) {
        $category_id = null;
        if (isset($params['category'])) {
            $category_id = (int) $params['category'];
        }
        $sub_category_id = null;
        if (isset($params['sub-category'])) {
            $sub_category_id = (int) $params['sub-category'];
        }
        $color = null;
        if (isset($params['color'])) {
            $color = $params['color'];
        }

        $items = Db::get_instance()->get_items(false, $category_id, $sub_category_id, null, $color);
        $colors = Db::get_instance()->get_colors();
        $categories = Db::get_instance()->get_categories();
        $brands = Db::get_instance()->get_brands();

        $this->render('design.php', [
            'page_title' => 'Desgin',
            'breadcrumbs' => [
                new Breadcrumb('Home', HOST),
                new Breadcrumb('Design', HOST . '/design', true)
            ],
            'items' => $items,
            'colors' => $colors,
            'categories' => $categories,
            'brands' => $brands,
            'category_id' => $category_id,
            'sub_category_id' => $sub_category_id,
            'color' => $color
        ]);
    }

    /**
     * Retrieves the list of items.
     */
    public function get_items($filter = null)
    {
        $category_id = null;
        $sub_category_id = null;
        $search_text = null;
        $color = null;
        $brands = [];
        $min_price = -1;
        $max_price = -1;
        if (isset($filter)) {
            if (isset($filter['category'])) {
                $category_id = $filter['category'];
            }
            if (isset($filter['sub-category'])) {
                $sub_category_id = $filter['sub-category'];
            }
            if (isset($filter['search-text'])) {
                $search_text = $filter['search-text'];
            }
            if (isset($filter['color'])) {
                $color = $filter['color'];
            }
            if (isset($filter['brands'])) {
                $brands = explode(',', $filter['brands']);
            }
            if (isset($filter['min-price'])) {
                $min_price = (int) $filter['min-price'];
            }
            if (isset($filter['max-price'])) {
                $max_price = (int) $filter['max-price'];
            }
        }
        $items = Db::get_instance()->get_items(true, $category_id, $sub_category_id, $search_text, $color, $brands, $min_price, $max_price);

        header('Content-Type: application/json');
        echo json_encode($items);

        exit;
    }

}