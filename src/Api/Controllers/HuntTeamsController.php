<?php
/**
 * Created by PhpStorm.
 * User: Darius
 * Date: 2.4.17
 * Time: 22:03
 */

namespace Course\Api\Controllers;


use Course\Api\Exceptions\Precondition;
use Course\Api\Exceptions\PreconditionException;
use Course\Api\Model\TeamModel;
use Course\Api\Model\TeamUsersModel;
use Course\Services\Http\Response;

class HuntTeamsController implements Controller
{

    public function get()
    {
        try {
            Precondition::isTrue(array_key_exists('huntId', $_GET), 'The parameter "huntId" is not set');
            Precondition::isTrue($_GET['huntId'] > 0, 'The parameter "huntId" is invalid');

        } catch (PreconditionException $e) {
            Response::showErrorResponse(ErrorCodes::INVALID_PARAMETER, $e->getMessage());
        }

        $huntId = $_GET['huntId'];
        $teams  = [];

        foreach (TeamModel::getTeamsByHunt($huntId) as $teamModel) {
            $teams[] = [
                'id'   => $teamModel->id,
                'name' => $teamModel->name,
            ];
        }

        Response::showSuccessResponse('joined teams retrieved', ['teams' => $teams]);
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