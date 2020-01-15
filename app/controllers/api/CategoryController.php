<?php

class CategoryController extends Controller
{

    public function index(){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(Category::findAll(), JSON_PRETTY_PRINT);
    }

    public function create(){
        // required headers
        header("Content-Type: application/json; charset=UTF-8");

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
                array("error" => "bad_request", "error_description" => "No enough information in Json file "),
                JSON_PRETTY_PRINT
            );
            return;
        }

        // create a new bean
        $category= new Category();
        // set category property values
        $category->name = $data->name;
        $category->description = $data->description;
        $category->created = $data->created;
        $category->modified = $data->modified;
        // store and check
        if($category->save()){
            header("HTTP/1.1 201 OK Created");
            echo json_encode(array("message" => "Category was created."), JSON_PRETTY_PRINT);
        }
        else{
            header("HTTP/1.1 400 Error");
            echo json_encode(array("message" => "Unable to create a new category."),JSON_PRETTY_PRINT);
        }
    }

    public function delete($params){
        // required headers
        header("Content-Type: application/json; charset=UTF-8");

        // get category to update
        $category = Category::find($params['id']);

        // delete category and check
        if($category->delete()){  
            header("HTTP/1.1 202 OK Deleted");
            echo json_encode(array("message" => "Category was deleted."), JSON_PRETTY_PRINT);
        }
        else{
            header("HTTP/1.1 400 Error");
            echo json_encode(array("message" => "Unable to delete selected category."), JSON_PRETTY_PRINT);
        }
    }

    public function update($params){
        // required headers
        header("Content-Type: application/json; charset=UTF-8");

        // get id of category to be edited
        $data = json_decode(file_get_contents("php://input"));

        // get category to update
        $category = Category::find($params['id']);

        // check if exists -> category is null
        if (!$category)
        {
            header("HTTP/1.1 404 Not Found");
            echo json_encode(array("error" => "not_found", "error_description" => "There is no items to update"),
                JSON_PRETTY_PRINT
            );
            return;
        }

        // update category with the new values elsewhere use older values
        $category->name = !isset($data->name) ? $category->name : $data->name;
        $category->description = !isset($data->description) ? $category->description :  $data->description;
        $category->created = !isset($data->created) ? $category->created :  $data->created;
        $category->modified = !isset($data->modified) ? $category->modified :  $data->modified;

        // update and checks
        if($category->update()){
            header("HTTP/1.1 201 OK Updated");
            echo json_encode(array("message"=>"Category was updated."), JSON_PRETTY_PRINT);
        }
        else{
            header("HTTP/1.1 400 Error");
            echo json_encode(array("message"=>"Unable to update selected category."), JSON_PRETTY_PRINT);
        }
    }

    public function show($params){
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(Category::find($params['id']), JSON_PRETTY_PRINT);
    }

    public function search(){
        // required headers
        header("Content-Type: application/json; charset=UTF-8");

        extract($_GET);

        // check for empty query string
        if ( !isset($name) && !isset($description) ){
            header("HTTP/1.1 400 Bad Request");
            echo '{"error":"invalid_request", "error_description":"There is no property"}';
            return;
        }

        // load default and sinitize
        $_name = isset($name) ? htmlspecialchars(strip_tags($name)) : '';
        $_description = isset($description) ? htmlspecialchars(strip_tags($description)) : '';

        echo json_encode(
            R::getAll('SELECT * FROM categories WHERE name LIKE ? AND description LIKE ? ORDER BY name ASC', ["%$_name%", "%$_description%" ] ), 
            JSON_PRETTY_PRINT
        );
    }

    public function first(){
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(Category::first(), JSON_PRETTY_PRINT);
    }

    public function last(){
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(Category::last(), JSON_PRETTY_PRINT);
    }

    public function count(){
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(Category::count(), JSON_PRETTY_PRINT);
    }

    public function category_product($params){
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode(
            R::getAll('SELECT p.name, p.id FROM categories c LEFT JOIN products p ON p.category_id = c.id WHERE c.id = :id ORDER BY p.id ASC', [':id' => $params['id']] ), 
            JSON_PRETTY_PRINT
        );
    }
}