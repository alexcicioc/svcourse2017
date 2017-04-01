<?php
/**
 * Created by PhpStorm.
 * User: Darius
 * Date: 1.4.17
 * Time: 23:39
 */

namespace Course\Api\Model;


class TeamUsersModel extends ActiveRecord
{
    protected static $config = [
        self::CONFIG_TABLE_NAME   => 'hunts',
        self::CONFIG_PRIMARY_KEYS => ['id'],
        self::CONFIG_DB_COLUMNS   => ['id', 'name', 'state'],
    ];

    /**
     * @return array
     */
    protected static function getConfig(): array
    {
        return self::$config;
    }
}