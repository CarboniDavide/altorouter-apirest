<?php

class CategoryControllerWeb
{
    public function index()
    {
        return view("category.index", ['categories' => Category::findAll()] );
    }
}