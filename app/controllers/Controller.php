<?php

class Controller{

    public function __construct($param)
    {
        $this->param = $param;
    }

    public function getParam()
    {
        return $this->param;
    }

    public function setParam($param)
    {
        $this->param = $param;
    }

    protected function controllerName()
    {
        $class_name = get_class($this);
        preg_match('/\\\\(.+?)Controller$/', $class_name, $matches);
        return $matches[1];
    }

    public function view($page, $data=null){
        $_page = str_replace(",", "/", $page);
        $_data = data;
        array_push($_data, array('page' => $page));
        return new View($_data);
    }
    
}