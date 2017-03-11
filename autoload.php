<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/11/2017
 * Time: 6:22 PM
 */

define('BASE_PATH', realpath(dirname(__FILE__)));
function my_autoloader($class)
{
    $class = str_replace('Course\\', '', $class);
    $filename = BASE_PATH . '/src/' . str_replace('\\', '/', $class) . '.php';
    include($filename);
}

spl_autoload_register('my_autoloader');