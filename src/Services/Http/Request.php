<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/11/2017
 * Time: 4:35 PM
 */

namespace Course\Services\Http;


class Request
{
    public static function getJsonBody()
    {
        $rawBody = file_get_contents("php://input");
        return json_decode($rawBody);
    }
}