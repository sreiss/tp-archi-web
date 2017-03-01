<?php

class Brand implements \JsonSerializable {
    private $name;
    private $count;

    public function __construct($name, $count) {
        $this->name = $name;
        $this->count = $count;
    }

    public static function deserialize(StdClass $json) {
        $color = new Brand($json->name, $json->count);
        return $color;
    }

    /**
     * @return string
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function get_count()
    {
        return $this->count;
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