<?php

class View
{
    protected $data;

    function __construct($data)
    {
        $this->data = $data;
        self::render();
    }

    function render()
    {
        // Extract the data so you can access all the variables in
        // the "data" array inside your included view files
        extract($this->data);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/shared/layout/layout.php';
    }
}
