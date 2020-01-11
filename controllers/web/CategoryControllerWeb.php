<?php

class CategoryControllerWeb
{
    public function index()
    {
        return new View( 
            [ 
                'page' => 'categories', 
                'categories' => R::getAll('SELECT * FROM categories') 
            ]
        );
    }
}