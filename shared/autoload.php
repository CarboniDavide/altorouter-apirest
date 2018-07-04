<?php
/**
 * Created by PhpStorm.
 * User: Davide
 * Date: 18.03.18
 * Time: 18:35
 */

include_once $_SERVER['DOCUMENT_ROOT'] . '/config/database.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/product.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/category.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/view.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/AltoRouter.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/utilities.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/api/categoryController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/api/productController.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/web/productControllerWeb.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/web/categoryControllerWeb.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/web/homeControllerWeb.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/controllers/api/apiController.php';