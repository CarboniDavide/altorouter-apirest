<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 23/03/2018
 * Time: 22:12
 */

class CategoryControllerWeb
{
    public function index()
    {
        return new View( 'categories.html', array('categories' => R::getAll('SELECT * FROM categories')) );
    }

}