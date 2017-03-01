<?php

require_once BASEPATH . '/models/sub-category.model.php';

class Category implements \JsonSerializable {
    private $id;
    private $name;
    private $sub_categories;
    private static $current_id = 0;

    public function __construct($name, $sub_categories) {
        $this->id = (self::$current_id + 1);
        $this->name = $name;
        $this->sub_categories = $sub_categories;
    }

    public static function deserialize(StdClass $json) {
        $subCategories = array_map(function($json) {
            return SubCategory::deserialize($json);
        }, $json->subCategories);

        $category = new Category($json->name, $subCategories);
        if (self::$current_id < $category->id) {
            self::$current_id = $category->id + 1;
        }
        $category->id = $json->id;
        return $category;
    }

    /**
     * @return int
     */
    public function get_id()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function get_name() {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function get_sub_categories()
    {
        return $this->sub_categories;
    }

    /**
     * @return int
     */
    public function get_items_count()
    {
        if (!empty($this->sub_categories)) {
            return array_reduce($this->sub_categories, function($value, $sub_category) {
                return $value + $sub_category->get_items_count();
            });
        }
        return 0;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return get_object_vars($this);
    }
}