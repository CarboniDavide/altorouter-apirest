<?php
/**
 * Created by PhpStorm.
 * User: Davide.CARBONI
 * Date: 22.03.2018
 * Time: 13:44
 */

class CategoryController
{
    public function read()
    {

        // required header
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // instantiate database and category object
        $database = new Database();
        $db = $database->getConnection();

        // initialize object
        $category = new Category($db);

        // query category
        $stmt = $category->read();
        $num = $stmt->rowCount();

        // check if more than 0 record found
        if($num>0){

            // products array
            $categories_arr=array();

            // retrieve our table contents
            // fetch() is faster than fetchAll()
            // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $category_item=array(
                    "id" => $id,
                    "name" => $name,
                    "description" => html_entity_decode($description),
                    "created" => $created,
                    "modified" => $modified
                );

                array_push($categories_arr, $category_item);
            }

            echo json_encode($categories_arr,JSON_PRETTY_PRINT);
        }

        else{
            header("HTTP/1.1 404 Not Found");
            echo json_encode(array("error"=>"not_found", "error_description"=>"There is no items"),JSON_PRETTY_PRINT);
            return;
            }
    }

    public function create(){
        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $database = new Database();
        $db = $database->getConnection();

        $category = new Category($db);

        // get posted data
        $data = json_decode(file_get_contents("php://input"));

        //verify Json file
        if (
            !isset($data->name) ||
            !isset($data->description) ||
            !isset($data->created) ||
            !isset($data->modified)
        ){
            header("HTTP/1.1 400 Bad request");
            echo json_encode(
                array("error"=>"bad_request", "error_description"=>"No enough information in Json file "),
                JSON_PRETTY_PRINT
            );
            return;
        }

        // set product property values
        $category->name = $data->name;
        $category->description = $data->description;
        $category->created = $data->created;
        $category->modified = $data->modified;

        // create the product
        if($category->create()){
            header("HTTP/1.1 201 OK Created");
            echo json_encode(array("message"=>"Product was created."),JSON_PRETTY_PRINT);
        }

        // if unable to create the product, tell the user
        else{
            header("HTTP/1.1 400 Error");
            echo json_encode(array("message"=>"Unable to create product."),JSON_PRETTY_PRINT);
        }
    }

    public function delete($param){
        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // prepare product object
        $category = new Category($db);

        // get category id
        //$data = json_decode(file_get_contents("php://input"));

        // set product id to be deleted
        //$product->id = $data->id;
        $category->id = $param['id'];

        if (!self::existe($category->id))
        {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(
                array("error"=>"not_found","error_description"=>"There is no items to delete"),
            JSON_PRETTY_PRINT);
            return;
        }

        // delete the product
        if($category->delete()){
            header("HTTP/1.1 202 OK Deleted");
            echo json_encode(array("message"=>"Product was deleted."),JSON_PRETTY_PRINT);
        }

        // if unable to delete the product
        else{
            header("HTTP/1.1 400 Error");
            echo json_encode(array("message"=>"Unable to delete object."),JSON_PRETTY_PRINT);
        }
    }

    public function update($params)
    {
        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: PUT");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // prepare product object
        $category = new Category($db);

        // get id of product to be edited
        $data = json_decode(file_get_contents("php://input"));

        // set ID property of category to be edited
        $category->id = $params['id'];

        if (!self::existe($category->id))
        {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(array("error"=>"not_found","error_description"=>"There is no items to update"),JSON_PRETTY_PRINT);
            return;
        }

        //verify Json file
        if (
            !isset($data->name) ||
            !isset($data->description) ||
            !isset($data->created) ||
            !isset($data->modified)
        ){
            header("HTTP/1.1 400 Bad request");
            echo json_encode(
                array("error"=>"bad_request", "error_description"=>"No enough information in Json file "),
                JSON_PRETTY_PRINT
            );
            return;
        }

        // set category property values
        $category->name = $data->name;
        $category->description = $data->description;
        $category->created = $data->created;
        $category->modified = $data->modified;

        // update the category
        if($category->update()){
            header("HTTP/1.1 201 OK Updated");
            echo json_encode(array("message"=>"Product was updated."),JSON_PRETTY_PRINT);
        }

        // if unable to update the category, tell the user
        else{
            header("HTTP/1.1 400 Error");
            echo json_encode(array("message"=>"Unable to update product."),JSON_PRETTY_PRINT);
        }
    }

    public function read_one($param)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json');

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // prepare category object
        $category = new Category($db);

        // set ID property of category to be edited
        $category->id = $param['id'];

        // read the details of category to be edited
        $category->readOne();

        if (!self::existe($category->id))
        {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(
                array("error"=>"not_found","error_description"=>"There is no items to read"),
                JSON_PRETTY_PRINT
            );
            return;
        }

        // create array
        $category_arr = array(
            "id" => $category->id,
            "name" => $category->name,
            "description" => $category->description,
            "created" => $category->created,
            "modified" => $category->modified
        );

        // make it json format
        echo json_encode($category_arr,JSON_PRETTY_PRINT);
    }

    public function search()
    {
        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        if (empty($_GET)){
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(
                array("error"=>"invalid_request", "error_description"=>"There is no property"),
                JSON_PRETTY_PRINT
            );
            return;
        }

        #create Keywords to search
        $keywords = array();

        extract($_GET);

        $keywords['name'] = isset($name) ? $name : '';
        $keywords['description'] = isset($description) ? $description : '';

        if (($keywords['name'] == '') && ($keywords['description'] == '')){
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(
                array("error"=>"invalid_request", "error_description"=>"There is no property"),
                JSON_PRETTY_PRINT
            );
            return;
        }

        // instantiate database and category object
        $database = new Database();
        $db = $database->getConnection();

        // initialize object
        $category = new Category($db);

        // query categories
        $stmt = $category->search($keywords);
        $num = $stmt->rowCount();

        // check if more than 0 record found
        if($num>0){

            // categories array
            $categories_arr=array();

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $category_item=array(
                    "id" => $id,
                    "name" => $name,
                    "description" => html_entity_decode($description),
                    "price" => $price,
                    "modified" => $modified,
                    "created" => $created,
                    "category_id" => $category_id
                );

                array_push($categories_arr, $category_item);
            }

            echo json_encode($categories_arr, JSON_PRETTY_PRINT);
        }

        else{
            header("HTTP/1.1 404 Not found");
            echo json_encode(
                array("message" => "No products found."),
                JSON_PRETTY_PRINT
            );
        }
    }

    // read last and first object
    private function readLimit($params)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json');

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // prepare category object
        $category = new Category($db);

        // read the details of product to be edited
        $params == "first" ? $category->readFirst() : $category->readLast();

        if ($category->name == null){
            header("HTTP/1.1 404 Not Found");
            echo json_encode(
                array("error"=>"not_found", "error_description"=>"There is no items"),
                JSON_PRETTY_PRINT
            );
            return;
        }

        // create array
        $category_arr = array(
            "id" => $category->id,
            "name" => $category->name,
            "description" => $category->description,
            "modified" => $category->modified,
            "created" => $category->created,
        );

        // make it json format
        echo json_encode($category_arr, JSON_PRETTY_PRINT);

    }

    // read first object
    public function readFirst()
    {
        self::readLimit("first");
    }

    // read last object
    public function readLast()
    {
        self::readLimit("last");
    }

    // count object
    public function count()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json');

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // prepare category object
        $category = new Category($db);

        $count = array("" => $category->count());
        echo json_encode($count, JSON_PRETTY_PRINT);
    }

    // read categories as products
    public function read_categories_as_products($params)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json');

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // prepare category object
        $category = new Category($db);

        // assign the id to search
        $category->id = $params['id'];

        // query category
        $stmt = $category->read_categories_as_products();
        $num = $stmt->rowCount();

        // check if more than 0 record found
        if ($num > 0) {

            // category array
            $products_arr["products"] = array();

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $product_item = $name;

                array_push($products_arr["products"], $product_item);
            }

            echo json_encode($products_arr, JSON_PRETTY_PRINT);
        } else {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(
                array("error"=>"not_found", "error_description"=>"There is no items"),
                JSON_PRETTY_PRINT
            );
            return;
        }
    }

    private function existe($id)
    {
        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // prepare product object
        $c = new Category($db);

        // set ID property of product to be edited
        $c->id = $id;

        // read the details of product to be edited
        $c->readOne();

        if ($c->rows == 0){
            return false;
        }
        return true;
    }

}