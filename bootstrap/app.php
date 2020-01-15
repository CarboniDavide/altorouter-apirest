<?php

// load app configuration
require_once BASE_DIR .'/config.php';

// include DB ORM
include_once BASE_DIR . '/includes/rb-mysql.php';

// database load config and set connection
$host = M_DB_HOST;
$db_name = M_DB_NAME;
$username = M_DB_USER;
$password = M_DB_PASS;

R::setup("mysql:host=$host;dbname=$db_name", $username, $password);

// include routes
require_once BASE_DIR . "/routes/dispatcher.php";



