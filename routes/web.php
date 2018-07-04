<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 23/03/2018
 * Time: 22:12
 */

$router->map( 'GET', '/products', 'productControllerWeb#index', 'read_products_web');
$router->map( 'GET', '/categories', 'categoryControllerWeb#index', 'read_categories_web');
$router->map( 'GET', '/', 'homeControllerWeb#index', 'home_page');
