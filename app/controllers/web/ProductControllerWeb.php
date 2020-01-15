<?php

class ProductControllerWeb
{
    public function index()
    {
        return new View( 
            [ 
                'page' => 'products', 
                'products' => R::getAll('SELECT * FROM products') 
            ]
        );
    }
}