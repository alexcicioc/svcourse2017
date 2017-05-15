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
use Course\Api\Model\TeamModel;
use Course\Api\Model\TeamUsersModel;
use Course\Api\Model\UserModel;
use Course\Services\Http\HttpConstants;
use Course\Services\Http\Request;
use Course\Services\Http\Response;
use HttpException;

class HuntTeamStateController implements Controller
{

    public function get()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }

    public function create()
    {
        $jsonRequest = Request::getJsonBody();
        $teamId      = $jsonRequest->teamId;
        $huntId      = $jsonRequest->huntId;
        $status      = $jsonRequest->status;

        try {
            Precondition::isPositiveInteger($teamId, 'teamId');
            Precondition::isPositiveInteger($huntId, 'teamId');
            Precondition::isInArray(
                $status,
                TeamUsersModel::ALL_STATUSES,
                'status'
            );
        } catch (PreconditionException $e) {
            Response::showErrorResponse(
                ErrorCodes::INVALID_PARAMETER,
                $e->getMessage()
            );
        }

        $teamModel = TeamModel::loadById($teamId);
        $userModel = Request::getAuthUser();

        if ($teamModel->owner_id != $userModel->id) {
            Response::showErrorResponse(
                ErrorCodes::USER_IS_NOT_TEAM_OWNER,
                'user is not team owner'
            );
        }

        if (!TeamUsersModel::existsByTeamUserAndHunt($teamId, $userModel->id, $huntId)) {
            Response::showErrorResponse(
                ErrorCodes::USER_IS_NOT_PART_OF_THE_HUNT,
                'user already joined the team'
            );
        }

        $teamUsers = TeamUsersModel::loadByTeamIdAndHuntId($teamId, $huntId);
        foreach ($teamUsers as $teamUserModel) {
            $teamUserModel->status = $status;
            $teamUserModel->save();
        }

        Response::showSuccessResponse('status changed for all team users');
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