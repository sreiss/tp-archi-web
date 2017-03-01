<?php

class SubCategory implements \JsonSerializable {
    private $id;
    private $name;
    private $items_count = 0;

    public function __construct($name) {
        $this->name = $name;
    }

    public static function deserialize(StdClass $json) {
        $subCategory = new SubCategory($json->name);
        $subCategory->id = $json->id;

        return $subCategory;
    }

    /**
     * @return mixed
     */
    public function get_id() {
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
    public function get_items_count()
    {
        return $this->items_count;
    }

    /**
     * @param mixed $items_count
     */
    public function set_items_count($items_count)
    {
        $this->items_count = $items_count;
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