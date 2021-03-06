<?php
namespace Course\Api\Model;

use Course\Api\Exceptions\Precondition;
use Course\Services\Persistence\MySql;

class HuntModel extends ActiveRecord
{
    // States definition
    const STATE_ACTIVE    = 'A';
    const STATE_STARTED   = 'S';
    const STATE_COMPLETED = 'C';

    // Available states
    const STATES = [
        self::STATE_ACTIVE,
        self::STATE_STARTED,
        self::STATE_COMPLETED,
    ];

    /**
     * @return array
     */
    protected static function getConfig(): array
    {
        return [
            self::CONFIG_TABLE_NAME   => 'hunts',
            self::CONFIG_PRIMARY_KEYS => ['id'],
            self::CONFIG_DB_COLUMNS   => ['id', 'name', 'state'],
        ];
    }

    public static function loadById(int $id): self
    {
        $result = MySql::getOne(self::getTableName(), ['id' => $id]);
        return new self($result);
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
        $results       = MySql::getMany(self::getTableName(), ['state' => $state]);

        foreach ($results as $result) {
            $huntModelList[] = new static($result);
        }

        return $huntModelList;
    }

    public function isActive() {
        return $this->state == self::STATE_ACTIVE;
    }
}