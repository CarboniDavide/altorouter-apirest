<?php

class ProductControllerWeb
{
    public function index()
    {
        return new View( 
            [ 
                'page' => 'product/products', 
                'products' => R::getAll('SELECT * FROM products') 
            ]
        );

        return view("product.product", ['products' => R::getAll('SELECT * FROM products')] );
    }
}