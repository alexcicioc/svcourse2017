<?php
/**
 * Created by PhpStorm.
 * User: Darius
 * Date: 2.4.17
 * Time: 22:16
 */

namespace Course\Api\Controllers;


use Course\Api\Exceptions\Precondition;
use Course\Api\Exceptions\PreconditionException;
use Course\Api\Model\TeamUsersModel;
use Course\Services\Http\Response;

class TeamMembersController implements Controller
{

    public function get()
    {
        try {
            Precondition::isTrue(array_key_exists('teamId', $_GET), 'The parameter "teamId" is not set');
            Precondition::isTrue($_GET['teamId'] > 0, 'The parameter "teamId" is invalid');

        } catch (PreconditionException $e) {
            Response::showErrorResponse(ErrorCodes::INVALID_PARAMETER, $e->getMessage());
        }

        $members = [];

        foreach (TeamUsersModel::loadByTeamId($_GET['teamId']) as $teamUsersModel) {
            $members[] = [
                'userId'   => $teamUsersModel->user_id,
                'username' => $teamUsersModel->getUserModel()->username,
                'isOwner'  => $teamUsersModel->getTeamModel()->owner_id == $teamUsersModel->user_id
            ];
        }

        Response::showSuccessResponse('Team members retrieved', ['members' => $members]);
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