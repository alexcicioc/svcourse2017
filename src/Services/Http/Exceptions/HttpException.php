<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/11/2017
 * Time: 5:43 PM
 */

namespace Course\Services\Http\Exceptions;

use Course\Api\Exceptions\ApiException;

class HttpException extends ApiException
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}