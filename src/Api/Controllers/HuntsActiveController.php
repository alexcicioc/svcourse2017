<?php
/**
 * Created by PhpStorm.
 * User: Darius
 * Date: 1.4.17
 * Time: 23:30
 */

namespace Course\Api\Controllers;

use Course\Api\Model\HuntModel;
use Course\Services\Http\Response;

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
        // TODO: Implement create() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}