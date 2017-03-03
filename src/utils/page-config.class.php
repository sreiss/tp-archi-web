<?php

class PageConfig {
    private static $instance;
    private $script_file;

    public static function get_instance() {
        if (!isset(self::$instance)) {
            self::$instance = new PageConfig();
        }
        return self::$instance;
    }

    /**
     * @return mixed
     */
    public function get_script_file()
    {
        return $this->script_file;
    }

    /**
     * @param mixed $script_file
     */
    public function set_script_file($script_file)
    {
        $this->script_file = $script_file;
    }
}