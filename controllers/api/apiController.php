<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 31/03/2018
 * Time: 00:26
 */

class ApiController
{

    public function index()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json');

        echo json_encode(
            array(
                "products_pagination_route" => "/products?limit={&limit_par_page}&page={&page_number}",
                "products_list_route" => "(GET) /products",
                "products_number_route" => "(GET)/products/[id]",
                "products_first_route" => "(GET)/products/first",
                "products_last_route" => "(GET)/products/last",
                "products_count_route" => "(GET)/products/count",
                "products_as_categories_route" => "(GET)/products/[id]/categories",
                "products_delete_route" => "(DELETE)/products/[id]",
                "products_create_route" => "(POST)/products with json passed in body",
                "products_update_route" => "(PUT) /products/[id] with a modified json product passed in body",
                "products_search_route" => "(GET) /products/search using name, description or price in query string eg: /search?name=LG",
                "categories_list_route" => "(GET) /categories",
                "categories_number_route" => "(GET) /categories/[id]",
                "categories_first_route" => "(GET) /categories/first",
                "categories_last_route" => "(GET) /categories/last",
                "categories_count_route" => "(GET) /categories/count",
                "categories_as_products_route" => "(GET) /categories/[id]/products",
                "categories_delete_route" => "(DELETE) /categories/[id]",
                "categories_create_route" => "(POST) /categories with a new json category passed in body",
                "categories_update_route" => "(PUT) /categories/[id] with a modified json category passed in body",
                "categories_search_route" => "(GET) /categories/search using name, description or price in query string eg: /search?price=12"
                ),
            JSON_PRETTY_PRINT
        );
    }
}
