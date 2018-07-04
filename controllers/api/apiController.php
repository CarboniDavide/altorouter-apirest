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
                "products_pagination_url" => "https://www.api.carboni.ch/products?limit={&limit_par_page}&page={&page_number}",
                "products_list_url" => "To do in exercise for student",
                "products_number_url" => "To do in exercise for student",
                "products_first_url" => "To do in exercise for student",
                "products_last_url" => "To do in exercise for student",
                "products_count_url" => "To do in exercise for student",
                "products_as_categories_url" => "To do in exercise for student",
                "products_delete_url" => "To do in exercise for student",
                "products_create_url" => "To do in exercise for student",
                "products_update_url" => "To do in exercise for student",
                "products_search_url" => "To do in exercise for student",
                "categories_list_url" => "To do in exercise for student",
                "categories_number_url" => "To do in exercise for student",
                "categories_first_url" => "To do in exercise for student",
                "categories_last_url" => "To do in exercise for student",
                "categories_count_url" => "To do in exercise for student",
                "categories_as_products_url" => "To do in exercise for student",
                "categories_delete_url" => "To do in exercise for student",
                "categories_create_url" => "To do in exercise for student",
                "categories_update_url" => "To do in exercise for student",
                "categories_search_url" => "To do in exercise for student"
                ),
            JSON_PRETTY_PRINT
        );
    }
}