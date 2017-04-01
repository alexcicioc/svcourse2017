<?php
namespace Course\Api\Model;

use Course\Api\Exceptions\Precondition;
use Course\Services\Persistence\MySql;

class HuntModel extends ActiveRecord
{
    protected static $config = [
        self::CONFIG_TABLE_NAME   => 'hunts',
        self::CONFIG_PRIMARY_KEYS => ['id'],
        self::CONFIG_DB_COLUMNS   => ['id', 'name', 'state'],
    ];

    const STATES = [
        'A', //Available
        'S', //Started
        'C', //Completed
    ];

    /**
     * @return array
     */
    protected static function getConfig(): array
    {
        return self::$config;
    }

    /**
     * @param string $state
     *
     * @return HuntModel[]
     * @throws \Course\Api\Exceptions\PreconditionException
     */
    public static function loadByState(string $state): array
    {
        Precondition::isTrue(in_array($state, self::STATES), 'The state is not valid');

        $huntModelList = [];
        $results       = MySql::getMulti(self::$config[self::CONFIG_TABLE_NAME], ['state' => $state]);

        foreach ($results as $result) {
            $huntModelList[] = new static($result);
        }

        return $huntModelList;
    }
}