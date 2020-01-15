<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 22/03/2018
 * Time: 18:22
 */

$prefix = API_PREFIX;

$router->map( 'GET', $prefix.'/', 'ApiController#index', 'api_index');

# Routes API Product
$router->map( 'GET', $prefix.'/products', 'ProductController#index', 'product_index');
$router->map( 'GET', $prefix.'/products/[i:id]', 'ProductController#show', 'product_show');
$router->map( 'GET', $prefix.'/products/first', 'ProductController#first', 'product_first');
$router->map( 'GET', $prefix.'/products/last', 'ProductController#last', 'product_last');
$router->map( 'GET', $prefix.'/products/count', 'ProductController#count', 'product_count');
$router->map( 'GET', $prefix.'/products/search', 'ProductController#search', 'product_search');
$router->map( 'GET', $prefix.'/products/[i:id]/categories', 'ProductController#product_category', 'products_as_category');

$router->map( 'PUT', $prefix.'/products/[i:id]', 'ProductController#update', 'product_update');
$router->map( 'DELETE', $prefix.'/products/[i:id]', 'ProductController#delete', 'product_delete');
$router->map( 'POST', $prefix.'/products', 'ProductController#create', 'product_create');

# Routes API Category
$router->map( 'GET', $prefix.'/categories', 'CategoryController#index', 'categoy_index');
$router->map( 'GET', $prefix.'/categories/[i:id]', 'CategoryController#show', 'category_show');
$router->map( 'GET', $prefix.'/categories/first', 'CategoryController#first', 'category_first');
$router->map( 'GET', $prefix.'/categories/last', 'CategoryController#last', 'category_last');
$router->map( 'GET', $prefix.'/categories/count', 'CategoryController#count', 'category_count');
$router->map( 'GET', $prefix.'/categories/search', 'CategoryController#search', 'category_search');
$router->map( 'GET', $prefix.'/categories/[i:id]/products', 'CategoryController#category_product', 'category_as_products');

$router->map( 'PUT', $prefix.'/categories/[i:id]', 'CategoryController#update', 'category_update');
$router->map( 'DELETE', $prefix.'/categories/[i:id]', 'CategoryController#delete', 'category_delete');
$router->map( 'POST', $prefix.'/categories', 'CategoryController#create', 'category_create');