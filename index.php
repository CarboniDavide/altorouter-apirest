<?php

/*
 * Carboni Davide
 * AltoRouter example
 *
 */

// load all classes
require_once("shared/autoload.php"); // Load all necessary class definitions

Database::setup();
$router = new AltoRouter();
$router->setBasePath('');

include_once ("routes/api.php"); // api routes
include_once ("routes/web.php"); // web routes

// match the routes
$match = $router->match();

if ($match === false) {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("HTTP/1.1 404 Not Found");
    $res = array("error" => "invalid_request", "error_description" => "The ". $_SERVER['REQUEST_URI']." do not exist");
    echo json_encode($res);
} else {
    list( $controller, $action ) = explode( '#', $match['target'] );
    if ( is_callable(array($controller, $action)) ) {
        call_user_func_array(array($controller,$action), array($match['params']));
    } else {
        echo "no match";
    }
}