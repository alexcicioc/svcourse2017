<?php
include "autoload.php";

use Course\Api\Controllers\Router;

$router = new Router($_GET['path'], $_SERVER['REQUEST_METHOD']);
var_dump($router->processRequest());

