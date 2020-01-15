<?php

class CategoryControllerWeb
{
    public function index()
    {
        return new View( 
            [ 
                'page' => 'category/index', 
                'categories' => R::getAll('SELECT * FROM categories') 
            ]
        );
    }
}