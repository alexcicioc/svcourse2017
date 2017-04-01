<?php
/**
 * Created by PhpStorm.
 * User: Darius
 * Date: 1.4.17
 * Time: 23:30
 */

namespace Course\Api\Controllers;


use Course\Api\Exceptions\Precondition;
use Course\Api\Exceptions\PreconditionException;
use Course\Api\Model\HuntModel;
use Course\Services\Http\Response;

class HuntsActiveController implements Controller
{

    public function get()
    {
        try {
            Precondition::isTrue(array_key_exists('state', $_GET), 'The parameter "state" is not provided');
            Precondition::isTrue(in_array($_GET['state'], HuntModel::STATES), 'The state is not valid');
        } catch (PreconditionException $e) {
            Response::showErrorResponse(ErrorCodes::INVALID_PARAMETER, $e->getMessage());
        }

        $hunts = HuntModel::loadByState($_GET['state']);

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