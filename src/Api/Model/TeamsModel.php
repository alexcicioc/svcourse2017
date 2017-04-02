<?php
/**
 * Created by PhpStorm.
 * User: Darius
 * Date: 2.4.17
 * Time: 21:54
 */

namespace Course\Api\Model;


use Course\Services\Persistence\MySql;

class TeamsModel extends ActiveRecord
{

    protected static function getConfig(): array
    {
        return [
            self::CONFIG_TABLE_NAME   => 'teams',
            self::CONFIG_PRIMARY_KEYS => ['id'],
            self::CONFIG_DB_COLUMNS   => ['id', 'name', 'owner_id'],
        ];
    }

    /**
     * @param int $id
     *
     * @return TeamsModel
     * @throws \Course\Services\Persistence\Exceptions\NoResultsException
     */
    public static function getById(int $id): self
    {
        $result = MySql::getOne(self::getTableName(), ['id' => $id]);

        return new static($result);
    }
}