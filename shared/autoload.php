<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 18.03.18
 * Time: 18:35
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/rb-mysql.php';
R::setup( 'mysql:host=localhost;dbname=api_db','test', 'test' );

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/' . $className . '.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/' . $className . '.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/api/' . $className . '.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/web/' . $className . '.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/config/' . $className . '.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/models/' . $className . '.php';
});