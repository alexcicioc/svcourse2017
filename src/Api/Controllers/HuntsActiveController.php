<?php
/**
 * Created by PhpStorm.
 * User: Darius
 * Date: 1.4.17
 * Time: 23:30
 */

namespace Course\Api\Controllers;

use Course\Api\Model\HuntModel;
use Course\Services\Http\HttpConstants;
use Course\Services\Http\Response;
use HttpException;

class HuntsActiveController implements Controller
{

    public function get()
    {
        $hunts = [];

        foreach (HuntModel::loadByState(HuntModel::STATE_ACTIVE) as $hunt) {
            $hunts[] = [
                'id'   => $hunt->id,
                'name' => $hunt->name
            ];
        }

        Response::showSuccessResponse('active hunts retrieved', ['hunts' => $hunts]);
    }

    public function create()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }

    public function update()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }

    public function delete()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }
}