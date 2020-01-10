<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 19/03/2018
 * Time: 18:52
 */

require_once('config/config.php');

class Database{

    // specify your own database credentials
    private $host = M_DB_HOST;
    private $db_name = M_DB_NAME;
    private $username = M_DB_USER;
    private $password = M_DB_PASS;
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
