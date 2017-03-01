<?php

class Route {
    private $file;
    private $controller;
    private $methods;

    function __construct($file, $controller, $methods)
    {
        $this->file = $file;
        $this->controller = $controller;
        $this->methods = $methods;
    }

    /**
     * @return mixed
     */
    public function get_file()
    {
        return $this->file;
    }

    /**
     * @return mixed
     */
    public function get_controller()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function get_methods()
    {
        return $this->methods;
    }
}