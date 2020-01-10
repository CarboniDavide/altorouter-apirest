<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 22/03/2018
 * Time: 18:22
 */

$router->map( 'GET', '/', 'ApiController#index', 'api_index');

# Routes API Product
$router->map( 'GET', '/products', 'ProductController#read', 'read_products');
$router->map( 'GET', '/products/[i:id]', 'ProductController#read_one', 'read_one_products');
$router->map( 'GET', '/products/[i:id]/categories', 'ProductController#read_product_as_category', 'read_one_products_as_category');
$router->map( 'GET', '/products/first', 'ProductController#readFirst', 'read_product_first');
$router->map( 'GET', '/products/last', 'ProductController#readLast', 'read_product_last');
$router->map( 'GET', '/products/count', 'ProductController#count', 'read_products_count');
$router->map( 'GET', '/products/search', 'ProductController#search', 'search_products');

$router->map( 'PUT', '/products/[i:id]', 'ProductController#update', 'update_product');
$router->map( 'DELETE', '/products/[i:id]', 'ProductController#delete', 'delete_product');
$router->map( 'POST', '/products', 'ProductController#create', 'create_product');

# Routes API Category
$router->map( 'GET', '/categories', 'CategoryController#read', 'read_categories');
$router->map( 'GET', '/categories/[i:id]', 'CategoryController#read_one', 'read_one_category');
$router->map( 'GET', '/categories/search', 'CategoryController#search', 'search_category');
$router->map( 'GET', '/categories/first', 'CategoryController#readFirst', 'read_category_first');
$router->map( 'GET', '/categories/last', 'CategoryController#readLast', 'read_category_last');
$router->map( 'GET', '/categories/count', 'CategoryController#count', 'read_category_count');
$router->map( 'GET', '/categories/[i:id]/products', 'CategoryController#read_categories_as_products', 'read_one_category_as_products');

$router->map( 'PUT', '/categories/[i:id]', 'CategoryController#update', 'update_category');
$router->map( 'DELETE', '/categories/[i:id]', 'CategoryController#delete', 'delete_category');
$router->map( 'POST', '/categories', 'CategoryController#create', 'create_category');