<?php

class CategoryControllerWeb
{
    public function index()
    {
        return new View( 
            [ 
                'page' => 'category/categories', 
                'categories' => R::getAll('SELECT * FROM categories') 
            ]
        );
    }
}