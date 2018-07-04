<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 22/03/2018
 * Time: 18:22
 */

$router->map( 'GET', '/', 'apiController#index', 'api_index');

# Routes API Product
$router->map( 'GET', '/products', 'productController#read', 'read_products');
$router->map( 'GET', '/products/[i:id]', 'productController#read_one', 'read_one_products');
$router->map( 'GET', '/products/[i:id]/categories', 'productController#read_product_as_category', 'read_one_products_as_category');
$router->map( 'GET', '/products/first', 'productController#readFirst', 'read_product_first');
$router->map( 'GET', '/products/last', 'productController#readLast', 'read_product_last');
$router->map( 'GET', '/products/count', 'productController#count', 'read_products_count');
$router->map( 'GET', '/products/search', 'productController#search', 'search_products');

$router->map( 'PUT', '/products/[i:id]', 'productController#update', 'update_product');
$router->map( 'DELETE', '/products/[i:id]', 'productController#delete', 'delete_product');
$router->map( 'POST', '/products', 'productController#create', 'create_product');

# Routes API Category
$router->map( 'GET', '/categories', 'categoryController#read', 'read_categories');
$router->map( 'GET', '/categories/[i:id]', 'categoryController#read_one', 'read_one_category');
$router->map( 'GET', '/categories/search', 'categoryController#search', 'search_category');
$router->map( 'GET', '/categories/first', 'categoryController#readFirst', 'read_category_first');
$router->map( 'GET', '/categories/last', 'categoryController#readLast', 'read_category_last');
$router->map( 'GET', '/categories/count', 'categoryController#count', 'read_category_count');
$router->map( 'GET', '/categories/[i:id]/products', 'categoryController#read_categories_as_products', 'read_one_category_as_products');

$router->map( 'PUT', '/categories/[i:id]', 'categoryController#update', 'update_category');
$router->map( 'DELETE', '/categories/[i:id]', 'categoryController#delete', 'delete_category');
$router->map( 'POST', '/categories', 'categoryController#create', 'create_category');