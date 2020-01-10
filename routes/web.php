<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 23/03/2018
 * Time: 22:12
 */

$router->map( 'GET', '/products', 'ProductControllerWeb#index', 'read_products_web');
$router->map( 'GET', '/categories', 'CategoryControllerWeb#index', 'read_categories_web');
$router->map( 'GET', '/', 'HomeControllerWeb#index', 'home_page');
