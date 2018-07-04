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
        // include database and object files


        // instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();

        // initialize object
        $category =  new Category($db);

        // query categories
        $stmt = $category->read();
        $num = $stmt->rowCount();

        // check if more than 0 record found
        if ($num > 0) {
            $categories = $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        return new View( 'categories.html', array('categories' => $categories));
    }

}