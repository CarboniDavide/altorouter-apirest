<?php

class ProductControllerWeb
{
    public function index()
    {
        return view("product.index", ['products' => Product::findAll()] );
    }
}