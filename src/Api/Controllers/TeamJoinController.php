<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/20/2017
 * Time: 6:31 PM
 */

namespace Course\Api\Controllers;


use Course\Api\Exceptions\Precondition;
use Course\Api\Exceptions\PreconditionException;
use Course\Api\Model\HuntModel;
use Course\Api\Model\TeamModel;
use Course\Api\Model\TeamUsersModel;
use Course\Api\Model\UserModel;
use Course\Services\Http\Exceptions\HttpException;
use Course\Services\Http\HttpConstants;
use Course\Services\Http\Request;
use Course\Services\Http\Response;
use Course\Services\Persistence\Exceptions\NoResultsException;
use Course\Services\Utils\StringUtils;

class TeamJoinController implements Controller
{
    // Handler for HTTP get methods
    public function get()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }

    // Handler for HTTP POST methods
    public function create()
    {
        $request = Request::getJsonBody();
        $huntId = $request->huntId;
        $teamId = $request->teamId;

        if (empty($huntId) || $huntId <= 0) {
            Response::showErrorResponse(
                ErrorCodes::INVALID_PARAMETER,
                'hunt id should be positive integer'
            );
        }

        if (empty($teamId) || $teamId <= 0) {
            Response::showErrorResponse(
                ErrorCodes::INVALID_PARAMETER,
                'team id should be positive integer'
            );
        }

        try {
            $huntModel = HuntModel::loadById($huntId);
        } catch (NoResultsException $e) {
            Response::showErrorResponse(
                ErrorCodes::INVALID_PARAMETER,
                'hunt id is not valid'
            );
        }

        try {
            $teamModel = TeamModel::loadById($teamId);
        } catch (NoResultsException $e) {
            Response::showErrorResponse(
                ErrorCodes::INVALID_PARAMETER,
                'team id is not valid'
            );
        }

        if (!$huntModel->isActive()) {
            Response::showErrorResponse(
                ErrorCodes::HUNT_IS_NOT_ACTIVE,
                'hunt is not active'
            );
        }


        $userModel = Request::getAuthUser();

        if (TeamUsersModel::existsByTeamUserAndHunt($teamId, $userModel->id, $huntId)) {
            Response::showErrorResponse(
                ErrorCodes::USER_ALREADY_JOINED_TEAM,
                'user already joined the team'
            );
        }

        TeamUsersModel::create($teamId, $userModel->id, $huntId);

        Response::showSuccessResponse('team joined');
    }

    // Handler for HTTP PUT methods
    public function update()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }

    // Handler for HTTP DELETE methods
    public function delete()
    {
        throw new HttpException('Method Now Allowed', HttpConstants::STATUS_CODE_METHOD_NOT_ALLOWED);
    }
}