<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 19/03/2018
 * Time: 18:52
 */

require_once (BASE_DIR .'/config/config.php');

class Database{

    public static function setup(){
        $host = M_DB_HOST;
        $db_name = M_DB_NAME;
        $username = M_DB_USER;
        $password = M_DB_PASS;
        
        R::setup("mysql:host=$host;dbname=$db_name", $username, $password);
    }
}
