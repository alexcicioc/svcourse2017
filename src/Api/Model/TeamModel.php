<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 3/27/2017
 * Time: 8:27 AM
 */

namespace Course\Api\Model;


use Course\Services\Persistence\Exceptions\NoResultsException;
use Course\Services\Persistence\MySql;

/**
 * Class TeamModel
 * @property int    $id
 * @property string $name
 * @property int    $owner_id
 */
class TeamModel extends ActiveRecord
{
    protected static function getConfig(): array
    {
        return [
            self::CONFIG_TABLE_NAME   => 'teams',
            self::CONFIG_DB_COLUMNS   => ['id', 'name', 'owner_id'],
            self::CONFIG_PRIMARY_KEYS => ['id'],
        ];
    }

    public static function create(string $name, int $ownerId): self
    {
        $teamId = MySql::insert(
            self::getTableName(),
            ['name' => $name, 'owner_id' => $ownerId]
        );

        return self::loadById($teamId);
    }

    public static function loadById(int $id): self
    {
        $result = MySql::getOne(self::getTableName(), ['id' => $id]);

        return new self($result);
    }

    /**
     * @param int $huntId
     *
     * @return TeamModel[]
     */
    public static function getTeamsByHunt(int $huntId): array
    {
        $results = MySql::getManyForCustomQuery("select * from " . self::getTableName()
            . " where id in (select distinct(team_id) from team_users where hunt_id = $huntId)");

        $teamModels = [];
        foreach ($results as $result) {
            $teamModels = new self($result);
        }

        return $teamModels;
    }
}