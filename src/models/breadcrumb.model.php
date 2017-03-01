<?php

class Breadcrumb {
    public $title;
    public $link;
    public $is_active;

    function __construct($title, $link, $is_active = false)
    {
        $this->title = $title;
        $this->link = $link;
        $this->is_active = $is_active;
    }

    /**
     * @return mixed
     */
    public function get_title()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function set_title($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function get_link()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function set_link($link)
    {
        $this->link = $link;
    }

    /**
     * @return bool
     */
    public function is_active()
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     */
    public function set_is_active($is_active)
    {
        $this->is_active = $is_active;
    }
}