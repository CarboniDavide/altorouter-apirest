<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 23/03/2018
 * Time: 19:08
 */

class ProductControllerWeb
{
    public function index()
    {
        // include database and object files


        // instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();

        // initialize object
        $product =  new Product($db);

        // query products
        $stmt = $product->read();
        $num = $stmt->rowCount();

        // check if more than 0 record found
        if ($num > 0) {
            $products = $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        return new View( 'products.html', array('products' => $products));
    }
}