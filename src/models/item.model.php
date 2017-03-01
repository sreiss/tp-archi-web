<?php

class Item implements \JsonSerializable {
    private $id;
    private $name;
    private $price;
    private $category_id;
    private $category;
    private $sub_category_id;
    private $color;
    private $rating;
    private $brand;
    private $special;
    private static $current_id = 0;

    function __construct($name, $price, $category_id, $sub_category_id, $color, $rating, $brand, $special = null)
    {
        self::$current_id += 1;
        $this->id = self::$current_id;
        $this->name = $name;
        $this->price = $price;
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
        $this->color = $color;
        $this->rating = $rating;
        $this->brand = $brand;
        $this->special = $special;
    }

    public static function deserialize(StdClass $json) {
        $special = (isset($json->special)) ? $json->special : null;
        $item = new Item($json->name, (int) $json->price, $json->categoryId, $json->subCategoryId, $json->color, $json->rating, $json->brand, $special);
        if (self::$current_id < $item->id) {
            self::$current_id = $item->id + 1;
        }
        $item->id = $json->id;
        return $item;
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
    public function get_name()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function set_name($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function get_price()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function set_price($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function get_category_id()
    {
        return $this->category_id;
    }

    /**
     * @return mixed
     */
    public function get_category()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function set_category($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function get_sub_category_id()
    {
        return $this->sub_category_id;
    }

    /**
     * @return mixed
     */
    public function get_color()
    {
        return $this->color;
    }

    /**
     * @return mixed
     */
    public function get_rating()
    {
        return $this->rating;
    }

    /**
     * @return mixed
     */
    public function get_brand()
    {
        return $this->brand;
    }

    /**
     * @return null
     */
    public function get_special()
    {
        return $this->special;
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