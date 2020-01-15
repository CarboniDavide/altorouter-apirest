<?php
/**
 * Created by PhpStorm.
 * User: Davide.CARBONI
 * Date: 27.03.2018
 * Time: 08:11
 */

class HomeControllerWeb
{
    public function index()
    {
        return new View( 
            [ 
                'page' => 'home/home', 
            ]
        );
    }
}