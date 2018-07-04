<?php

/**
 * Created by PhpStorm.
 * User: Davide Carboni
 * Date: 20/03/2018
 * Time: 20:11
 */


class ProductController
{
    private $param;

    /**
     * productController constructor.
     * @param $param
     */
    public function __construct($param)
    {
        $this->param = $param;
    }

    /**
     * @return mixed
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * @param mixed $param
     */
    public function setParam($param)
    {
        $this->param = $param;
    }

    public function read()
    {
        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        #Vefiry for pagination request$
        if (isset($_GET['limit']) || isset($_GET['page'])){

            // page given in limit parameter without black space, default limit is five
            $limit = isset($_GET['limit']) ? preg_replace('/\s+/', '', $_GET['limit']) : 5;

            // page given in URL parameter without black space, default page is one
            $page = isset($_GET['page']) ? preg_replace('/\s+/', '', $_GET['page']) : 1;

            preg_match('/^[0-9]{1,45}$/',$page, $matches_page);
            preg_match('/^[0-9]{1,45}$/',$limit, $matches_limit);

            // Verify if page is valid
            if (!isset($matches_page[0])) {
                header("HTTP/1.1 400 Bad Request");
                echo json_encode(array("error"=>"invalid_request", "error_description"=>"There is no valid property")
                    ,JSON_PRETTY_PRINT
                );
                return;
            }

            // Verify if limit is valid
            if (!isset($matches_limit[0])) {
                header("HTTP/1.1 400 Bad Request");
                echo json_encode(array("error"=>"invalid_request", "error_description"=>"There is no valid property")
                    ,JSON_PRETTY_PRINT
                );
                return;
            }

            $limit = (int)$limit;
            $page = (int)$page;

            // home page url
            $home_url = "https://www.api.carboni.ch/";

            // set number of records per page
            $records_per_page = $limit;

            // calculate for the query LIMIT clause
            $from_record_num = ($records_per_page * $page) - $records_per_page;

            self::read_pagination($from_record_num,$records_per_page, $home_url, $page);
            return;
        }

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

            // products array
            $products_arr = array();

            // retrieve our table contents
            // fetch() is faster than fetchAll()
            // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $product_item = array(
                    "id" => $id,
                    "name" => $name,
                    "description" => html_entity_decode($description),
                    "price" => $price,
                    "modified" => $modified,
                    "created" => $created,
                    "category_id" => $category_id
                );

                array_push($products_arr, $product_item);
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
        $p = new Product($db);

        // set ID property of product to be edited
        $p->id = $id;

        // read the details of product to be edited
        $p->readOne();

        if ($p->rows == 0){
            return false;
        }
        return true;
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

        // prepare product object
        $product = new Product($db);

        // set ID property of product to be edited
        $product->id = $param['id'];

        // read the details of product to be edited
        $product->readOne();

        if ($product->rows == 0){
            header("HTTP/1.1 404 Not Found");
            echo json_encode(
                array("error"=>"not_found", "error_description"=>"There is no items to read"),
                JSON_PRETTY_PRINT
            );
            return;
        }

        // create array
        $product_arr = array(
            "id" => $product->id,
            "name" => $product->name,
            "description" => $product->description,
            "price" => $product->price,
            "modified" => $product->modified,
            "created" => $product->created,
            "category_id" => $product->category_id
        );

        // make it json format
        echo json_encode($product_arr, JSON_PRETTY_PRINT);
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

        $product = new Product($db);

        // get posted data
        $data = json_decode(file_get_contents("php://input"));

        //verify Json file
        if (
            !isset($data->name) ||
            !isset($data->price) ||
            !isset($data->description) ||
            !isset($data->category_id) ||
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
        $product->name = $data->name;
        $product->price = $data->price;
        $product->description = $data->description;
        $product->category_id = $data->category_id;
        $product->created = $data->created;
        $product->modified = $data->modified;

        // create the product
        if($product->create()){
            header("HTTP/1.1 201 OK Created");
            echo json_encode(array("message"=>"Product was created."),JSON_PRETTY_PRINT);
        }

        // if unable to create the product, tell the user
        else{
            header("HTTP/1.1 400 Error");
            echo json_encode(array("message"=>"Unable to create product."),JSON_PRETTY_PRINT);
        }
    }

    public function delete($params){
        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // prepare product object
        $product = new Product($db);

        // get product id
        //$data = json_decode(file_get_contents("php://input"));

        // set product id to be deleted
        //$product->id = $data->id;
        $product->id = $params['id'];

        if (!self::existe($product->id))
        {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(array("error"=>"not_found","error_description"=>"There is no items to delete"),JSON_PRETTY_PRINT);
            return;
        }

        // delete the product
        if($product->delete()){
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
        $product = new Product($db);

        // get id of product to be edited
        $data = json_decode(file_get_contents("php://input"));

        // set ID property of product to be edited
        $product->id = $params['id'];

        if (!self::existe($product->id))
        {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(array("error"=>"not_found","error_description"=>"There is no items to update"),
                JSON_PRETTY_PRINT
            );
            return;
        }

        //verify Json file
        if (
            !isset($data->name) ||
            !isset($data->price) ||
            !isset($data->description) ||
            !isset($data->category_id) ||
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
        $product->name = $data->name;
        $product->price = $data->price;
        $product->description = $data->description;
        $product->modified = $data->modified;
        $product->created = $data->created;
        $product->category_id = $data->category_id;

        // update the product
        if($product->update()){
            header("HTTP/1.1 201 OK Updated");
            echo json_encode(array("message"=>"Product was updated."),JSON_PRETTY_PRINT);
        }

        // if unable to update the product, tell the user
        else{
            header("HTTP/1.1 400 Error");
            echo json_encode(array("message"=>"Unable to update product."),JSON_PRETTY_PRINT);
        }
    }

    public function search()
    {
        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        if (empty($_GET)){
            header("HTTP/1.1 400 Bad Request");
            echo '{"error":"invalid_request", "error_description":"There is no property"}';
            return;
        }

        #create Keywords to search
        $keywords = array();

        extract($_GET);

        $keywords['name'] = isset($name) ? $name : '';
        $keywords['description'] = isset($description) ? $description : '';
        $keywords['price'] = isset($price) ? $price : '';

        if (($keywords['name'] == '') && ($keywords['description'] == '') && ($keywords['price'] == '')){
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(
                array("error" => "invalid_request", "error_description" => "There is no property"),
                JSON_PRETTY_PRINT
            );
            return;
        }

        // instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();

        // initialize object
        $product = new Product($db);

        // query products
        $stmt = $product->search($keywords);
        $num = $stmt->rowCount();

        // check if more than 0 record found
        if($num>0){

            // products array
            $products_arr=array();

            // retrieve our table contents
            // fetch() is faster than fetchAll()
            // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $product_item=array(
                    "id" => $id,
                    "name" => $name,
                    "description" => html_entity_decode($description),
                    "price" => $price,
                    "modified" => $modified,
                    "created" => $created,
                    "category_id" => $category_id
                );

                array_push($products_arr, $product_item);
            }

            echo json_encode($products_arr, JSON_PRETTY_PRINT);
        }

        else{
            header("HTTP/1.1 404 Not Found");
            echo json_encode(
                array("error" => "not_found", "error_description" => "There is no items"),
                JSON_PRETTY_PRINT
            );
            return;
        }
    }

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

        // prepare product object
        $product = new Product($db);

        // set ID property of product to be edited

        // read the details of product to be edited
        $params == "first" ? $product->readFirst() : $product->readLast();

        if ($product->name == null){
            header("HTTP/1.1 404 Not Found");
            echo json_encode(
                array("error"=>"not_found", "error_description"=>"There is no items"),
                JSON_PRETTY_PRINT
            );
            return;
        }

        // create array
        $product_arr = array(
            "id" => $product->id,
            "name" => $product->name,
            "description" => $product->description,
            "price" => $product->price,
            "modified" => $product->modified,
            "created" => $product->created,
            "category_id" => $product->category_id
        );

        // make it json format
        echo json_encode($product_arr,JSON_PRETTY_PRINT);

    }

    public function readFirst()
    {
        self::readLimit("first");
    }

    public function readLast()
    {
        self::readLimit("last");
    }

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

        // prepare product object
        $product = new Product($db);

        // set ID property of product to be edited

        // read the details of product to be edited
        $count = array("" => $product->count());
        echo json_encode($count);
    }


    public function read_product_as_category($params)
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: access");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json');

        // get database connection
        $database = new Database();
        $db = $database->getConnection();

        // prepare product object
        $product = new Product($db);

        // assign the id to search
        $product->id = $params['id'];

        // query products
        $stmt = $product->read_product_as_category();
        $num = $stmt->rowCount();

        // check if more than 0 record found
        if ($num > 0) {

            // products array
            $categories_arr["categories"] = array();

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $category_item = $name;

                array_push($categories_arr["categories"], $category_item);
            }

            echo json_encode($categories_arr);
        } else {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(
                array("error" => "not_found", "error_description" => "There is no items"),
                JSON_PRETTY_PRINT
            );
            return;
        }
    }

    private function read_pagination($from_record_num, $records_per_page, $home_url, $page){

        // required headers
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        // utilities
        $utilities = new Utilities();

        // instantiate database and product object
        $database = new Database();
        $db = $database->getConnection();

        // initialize object
        $product = new Product($db);

        // query products
        $stmt = $product->readPaging($from_record_num, $records_per_page);
        $num = $stmt->rowCount();

        // check if more than 0 record found
        if($num>0){

            // products array
            $products_arr=array();
            $products_arr["records"]=array();
            $products_arr["paging"]=array();

            // retrieve our table contents
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row);

                $product_item=array(
                    "id" => $id,
                    "name" => $name,
                    "description" => html_entity_decode($description),
                    "price" => $price,
                    "category_id" => $category_id,
                    "category_name" => $category_name
                );

                array_push($products_arr["records"], $product_item);
            }


            // include paging
            $total_rows=$product->count();
            $page_url="{$home_url}products?limit={$records_per_page}&";
            $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
            $products_arr["paging"]=$paging;

            echo json_encode($products_arr,JSON_PRETTY_PRINT);
        }

        else{
            echo json_encode(
                array("message" => "No products found.")
            );
        }
    }

}

