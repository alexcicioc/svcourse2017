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

class TeamController implements Controller
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
        $name = $request->name;
        $huntId = $request->huntId;

        if (strlen($request->name) < 4) {
            Response::showErrorResponse(
                ErrorCodes::INVALID_PARAMETER,
                'team name length should be 4 or greater'
            );
        }
        if (empty($huntId) || $huntId <= 0) {
            Response::showErrorResponse(
                ErrorCodes::INVALID_PARAMETER,
                'hunt id should be positive integer'
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

        if (!$huntModel->isActive()) {
            Response::showErrorResponse(
                ErrorCodes::HUNT_IS_NOT_ACTIVE,
                'hunt is not active'
            );
        }

//        try {
//            $userModel = UserModel::loadUserFromSession();
//        } catch (NoResultsException $e) {
//            Response::showErrorResponse(
//                ErrorCodes::USER_NOT_LOGGED_ID,
//                'user is not logged in'
//            );
//        }

        $userModel = Request::getAuthUser();

        $teamModel = TeamModel::create($name, $userModel->id);
        TeamUsersModel::create($teamModel->id, $userModel->id, $huntId);

        Response::showSuccessResponse('team created', ['teamId' => $teamModel->id]);
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