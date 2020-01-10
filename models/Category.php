<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 19/03/2018
 * Time: 19:34
 */

class Category{

    // database connection and table name
    private $conn;
    private $table_name = "categories";

    // object properties
    public $id;
    public $name;
    public $description;
    public $created;
    public $modified;
    public $rows;

    public function __construct($db){
        $this->conn = $db;
    }

    // read categories
    public function read(){

        //select all data
        $query = "SELECT
                id, name, description, created, modified
            FROM
                " . $this->table_name . "
            ORDER BY
                id ASC";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    // create category
    function create(){

        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, description=:description, created=:created, modified=:modified";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->modified=htmlspecialchars(strip_tags($this->modified));

        // bind values
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":created", $this->created);
        $stmt->bindParam(":modified", $this->modified);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }

    // update the category
    function update(){

        // update query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                description = :description,
                modified = :modified,
                created = :created
            WHERE
                id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->created=htmlspecialchars(strip_tags($this->created));
        $this->modified=htmlspecialchars(strip_tags($this->modified));

        // bind new values
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':modified', $this->mmodified);
        $stmt->bindParam(':created', $this->created);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // delete the category
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // search category
    function search($keywords){

        // select all query
        $query = "SELECT
                c.id, c.name, c.description, c.created, c.modified
            FROM
                " . $this->table_name . " c
            WHERE
                c.name LIKE ? AND c.description LIKE ?
            ORDER BY
                c.created ASC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $keywords['name']=htmlspecialchars(strip_tags($keywords['name']));
        $keywords['description']=htmlspecialchars(strip_tags($keywords['description']));

        // bind
        $stmt->bindParam(1, $keywords['name']);
        $stmt->bindParam(2, $keywords['description']);

        //adjust
        $keywords['name'] = "%{$keywords['name']}%";
        $keywords['description'] = "%{$keywords['description']}%";

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // used when filling up the update product form
    function readOne(){

        // query to read single record
        $query = "SELECT
                c.id, c.name, c.description, c.created, c.modified
            FROM
                " . $this->table_name . " c
            WHERE
                c.id = ?
            LIMIT
                0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // rows count
        $this->rows = $stmt->rowCount();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->created = $row['created'];
        $this->modified = $row['modified'];
    }

    // count
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }


    // Read first and last object
    private function readLimit($params)
    {
        if ($params == 'first') {
            $query = "SELECT
                c.id, c.name, c.description, c.created, c.modified
            FROM
                " . $this->table_name . " c
            ORDER BY
                c.id ASC
            LIMIT
                0,1";
        }else{
            $query = "SELECT
                c.id, c.name, c.description, c.created, c.modified
            FROM
                " . $this->table_name . " c
            ORDER BY
                c.id DESC
            LIMIT
                0,1";
        }

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->created = $row['created'];
        $this->modified = $row['modified'];
    }

    //read first object
    public function readFirst()
    {
        self::readLimit("first");
    }

    //read last object
    public function readLast()
    {
        self::readLimit("last");
    }

    // read products as categories
    function read_categories_as_products(){

        // select all query
        $query = "SELECT
                p.name
            FROM
                " . $this->table_name . " c
                LEFT JOIN
                    products p
                        ON p.category_id = c.id
            WHERE
                c.id = ?
            ORDER BY
                p.id ASC";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        return $stmt;
    }


}
