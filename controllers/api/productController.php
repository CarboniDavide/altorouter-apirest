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
        echo json_encode(R::getAll('SELECT * FROM products'), JSON_PRETTY_PRINT);
    }

    private function existe($id)
    {
        return R::findOne('products','id = ?', [$id]) ? true : false;
    }

    public function read_one($param)
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(R::getRow('SELECT * FROM products WHERE id = ?', [$param['id']]), JSON_PRETTY_PRINT);
    }

    public function create(){
        // required headers
        header("Content-Type: application/json; charset=UTF-8");

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

        // create a new bean
        $product= R::dispense( 'products' );
        // set product property values
        $product->name = $data->name;
        $product->price = $data->price;
        $product->description = $data->description;
        $product->category_id = $data->category_id;
        $product->created = $data->created;
        $product->modified = $data->modified;
        // store and check
        if(R::store( $product )){
            header("HTTP/1.1 201 OK Created");
            echo json_encode(array("message"=>"Product was created."), JSON_PRETTY_PRINT);
        }
        else{
            header("HTTP/1.1 400 Error");
            echo json_encode(array("message"=>"Unable to create product."),JSON_PRETTY_PRINT);
        }
    }

    public function delete($params){
        // required headers
        header("Content-Type: application/json; charset=UTF-8");

        // delete product and check
        // hunt return the number of delected rows elsewhere 0
        if(R::hunt('products','id = ?', [ $params['id'] ])){  
            header("HTTP/1.1 202 OK Deleted");
            echo json_encode(array("message"=>"Product was deleted."), JSON_PRETTY_PRINT);
        }
        else{
            header("HTTP/1.1 400 Error");
            echo json_encode(array("message"=>"Unable to delete object."), JSON_PRETTY_PRINT);
        }
    }

    public function update($params)
    {
        // required headers
        header("Content-Type: application/json; charset=UTF-8");

        // get id of product to be edited
        $data = json_decode(file_get_contents("php://input"));

        // get product to update
        $product = R::findOne('products', 'id = ?', [ $params['id'] ]);

        // check if exists -> product is null
        if (!$product)
        {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(array("error"=>"not_found","error_description"=>"There is no items to update"),
                JSON_PRETTY_PRINT
            );
            return;
        }

        // update product with the new values elsewhere use older values
        $product->name = !isset($data->name) ? $product->name : $data->name;
        $product->price = !isset($data->price) ? $product->price :  $data->price;
        $product->description = !isset($data->description) ? $product->description :  $data->description;
        $product->modified = !isset($data->modified) ? $product->modified :  $data->modified;
        $product->created = !isset($data->created) ? $product->created :  $data->created;
        $product->category_id = !isset($data->category_id) ? $product->category_id :  $data->category_id;

        // update and check
        if(R::store( $product )){
            header("HTTP/1.1 201 OK Updated");
            echo json_encode(array("message"=>"Product was updated."), JSON_PRETTY_PRINT);
        }
        else{
            header("HTTP/1.1 400 Error");
            echo json_encode(array("message"=>"Unable to update product."), JSON_PRETTY_PRINT);
        }
    }

    public function search()
    {
        // required headers
        header("Content-Type: application/json; charset=UTF-8");

        extract($_GET);

        // check for empty query string
        if ( !isset($name) && !isset($description) && !isset($price) ){
            header("HTTP/1.1 400 Bad Request");
            echo '{"error":"invalid_request", "error_description":"There is no property"}';
            return;
        }

        // load default and sinitize
        $_name = isset($name) ? htmlspecialchars(strip_tags($name)) : '';
        $_description = isset($description) ? htmlspecialchars(strip_tags($description)) : '';
        $_price = isset($price) ? htmlspecialchars(strip_tags($price)) : '';

        echo json_encode(
            R::getAll('SELECT * FROM products WHERE name LIKE ? AND description LIKE ? AND price LIKE ? ORDER BY name ASC', ["%$_name%", "%$_description%", "%$_price%"] ), 
            JSON_PRETTY_PRINT
        );
    }

    public function readFirst()
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(R::getRow('SELECT * FROM products ORDER BY id ASC LIMIT 0,1'), JSON_PRETTY_PRINT);
    }

    public function readLast()
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(R::getRow('SELECT * FROM products ORDER BY id DESC LIMIT 0,1'), JSON_PRETTY_PRINT);
    }

    public function count()
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(R::getRow('SELECT COUNT(*) as total_rows FROM products'), JSON_PRETTY_PRINT);
    }


    public function read_product_as_category($params)
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(
            R::getAll('SELECT c.name, c.id FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = :id ORDER BY p.id ASC', [':id' => $params['id']] ), 
            JSON_PRETTY_PRINT
        );
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

