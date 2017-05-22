<?php
/**
 * Created by PhpStorm.
 * User: Darius
 * Date: 1.4.17
 * Time: 23:39
 */

namespace Course\Api\Model;


use Course\Services\Persistence\Exceptions\NoResultsException;
use Course\Services\Persistence\MySql;

class TeamUsersModel extends ActiveRecord
{
    protected static $config = [
        self::CONFIG_TABLE_NAME   => 'team_users',
        self::CONFIG_PRIMARY_KEYS => ['id'],
        self::CONFIG_DB_COLUMNS   => ['id', 'team_id', 'user_id', 'hunt_id', 'status'],
    ];

    const STATUS_NOT_READY = 'N';
    const STATUS_READY     = 'R';

    const ALL_STATUSES = [self::STATUS_NOT_READY, self::STATUS_READY];

    /** @var TeamsModel */
    protected $teamModel;
    /** @var UserModel */
    protected $userModel;

    /**
     * @return array
     */
    protected static function getConfig(): array
    {
        return self::$config;
    }


    public static function create(int $teamId, int $userId, int $huntId): self
    {
        $id = MySql::insert(self::getTableName(), ['team_id' => $teamId, 'hunt_id' => $huntId, 'user_id' => $userId]);

        return self::loadById($id);
    }

    public static function loadById(int $id): self
    {
        $result = MySql::getOne(self::getTableName(), ['id' => $id]);

        return new self($result);
    }

    public static function existsByTeamUserAndHunt(int $teamId, int $userId, int $huntId): bool
    {
        try {
            MySql::getOne(self::getTableName(),
                ['team_id' => $teamId, 'user_id' => $userId, 'hunt_id' => $huntId]
            );

            return true;
        } catch (NoResultsException $e) {
            return false;
        }
    }

    /**
     * @param int $huntId
     *
     * @return TeamUsersModel[]
     */
    public static function loadByHuntId(int $huntId): array
    {
        $results = MySql::getMany(self::getTableName(), ['hunt_id' => $huntId]);
        $models  = [];

        foreach ($results as $result) {
            $models[] = new static($result);
        }

        return $models;
    }

    /**
     * @param int $huntId
     *
     * @return TeamUsersModel[]
     */
    public static function getDistinctHuntTeams(int $huntId): array
    {
        $results = MySql::getManyForCustomQuery(
            "select * from `" . self::getTableName() . "` where team_id in (
            select DISTINCT(team_id) as `team_id` from `" . self::getTableName() . "` where `hunt_id` = $huntId 
            )"
        );
        $models  = [];

        foreach ($results as $result) {
            $models[] = new static($result);
        }

        return $results;
    }

    /**
     * @param int $teamId
     *
     * @return TeamUsersModel[]
     */
    public static function loadByTeamId(int $teamId): array
    {
        $results = MySql::getMany(self::getTableName(), ['team_id' => $teamId]);
        $models  = [];

        foreach ($results as $result) {
            $models[] = new static($result);
        }

        return $models;
    }

    /**
     * @param int $teamId
     * @param int $huntId
     *
     * @return array|TeamUsersModel[]
     */
    public static function loadByTeamIdAndHuntId(int $teamId, int $huntId): array
    {
        $results = MySql::getMany(
            self::getTableName(),
            ['team_id' => $teamId, 'hunt_id' => $huntId]
        );
        $models  = [];

        foreach ($results as $result) {
            $models[] = new static($result);
        }

        return $models;
    }

    /**
     * @return TeamsModel
     */
    public function getTeamModel()
    {
        if (is_null($this->teamModel)) {
            $this->teamModel = TeamsModel::getById($this->team_id);
        }

        return $this->teamModel;
    }

    /**
     * @return UserModel
     */
    public function getUserModel()
    {
        if (is_null($this->userModel)) {
            $this->userModel = UserModel::loadById($this->user_id);
        }

        return $this->userModel;
    }
}