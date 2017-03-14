<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/11/2017
 * Time: 6:22 PM
 */

define('BASE_PATH', realpath(dirname(__FILE__)));

function customAutoLoader($class)
{
    $class = str_replace('Course\\', '', $class);
    $filename = BASE_PATH . '/src/' . str_replace('\\', '/', $class) . '.php';
    require $filename;
}

spl_autoload_register('customAutoLoader');