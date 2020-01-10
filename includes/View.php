<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 24/03/2018
 * Time: 16:27
 */


class View
{
    protected $data = array();
    protected $path;

    function __construct($path, array $data = array())
    {
        $this->path = $path;
        $this->data = $data;
        self::render();
    }

    function render()
    {
        // Extract the data so you can access all the variables in
        // the "data" array inside your included view files
        extract($this->data);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/views/' . $this->path;
    }

    /**
     * Make it able for you to write a code like this: echo new View("home.php")
     */
    function __toString()
    {
        return $this->render();
    }
}
