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
    public static function setup(){
        R::setup('mysql:host=localhost;dbname=api_db', 'test', 'test');
    }
}
