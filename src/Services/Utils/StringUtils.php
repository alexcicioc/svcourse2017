<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/19/2017
 * Time: 2:54 PM
 */

namespace Course\Services\Utils;


class StringUtils
{
    public static function encryptPassword($string)
    {
        return md5(PASSWORD_SALT . $string);
    }
}