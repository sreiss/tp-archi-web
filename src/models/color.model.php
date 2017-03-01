<?php

class Color implements \JsonSerializable {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public static function deserialize(StdClass $json) {
        $color = new Color($json->name);
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