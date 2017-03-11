<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/11/2017
 * Time: 5:03 PM
 */

namespace Course\Api\Exceptions;


class Precondition
{
    public static function isTrue(bool $condition, string $message)
    {
        if ($condition !== true) {
            self::throwException($message);
        }
    }

    private static function throwException($message)
    {
        throw new ApiException($message);
    }
}