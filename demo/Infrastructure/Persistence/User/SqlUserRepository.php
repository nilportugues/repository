<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/21/15
 * Time: 1:36 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Demo\Infrastructure\Persistence\User;

use InvalidArgumentException;
use PhpDdd\Demo\Domain\User\User;
use PhpDdd\Demo\Domain\User\UserId;
use PhpDdd\Demo\Infrastructure\Persistence\SqlEntityRepository;
use PhpDdd\Demo\Infrastructure\Persistence\SqlRepository;
use PhpDdd\Foundation\Domain\Repository\CrudRepository;
use PhpDdd\Foundation\Domain\Repository\Filter;
use PhpDdd\Foundation\Domain\Repository\Page;
use PhpDdd\Foundation\Domain\Repository\Pageable;
use PhpDdd\Foundation\Domain\Repository\Sort;

class SqlUserRepository extends SqlEntityRepository
{
    /**
     * @var string
     */
    protected $tableName = 'users';

    /**
     * @var array
     */
    protected $primaryKey = [
        'users.user_id'
    ];

    /**
     * @var array
     */
    protected $columns = [
        'users.user_id',
        'users.name',
        'users.birthdate',
        'users.email',
    ];

    /**
     * Returns the next identity value.
     *
     * @return UserId
     */
    public function nextIdentity()
    {
        return new UserId();
    }

    /**
     * @param $value
     *
     * @throws \InvalidArgumentException
     */
    protected function guardForEntity($value)
    {
        if (false === ($value instanceof User)) {
            throw new InvalidArgumentException(
                sprintf('Provided $value is not and instance of %s', User::class)
            );
        }
    }

    /**
     * @param User $value
     *
     * @return mixed
     */
    protected function entityToArray($value)
    {
        return [
            (string) $value->userId(),
            (string) $value->name(),
            (string) $value->birthDate(),
            (string) $value->email(),
        ];
    }

    /**
     * @param $id
     *
     * @throws \InvalidArgumentException
     */
    protected function guardForIdentity($id)
    {
        if (false === ($id instanceof UserId)) {
            throw new InvalidArgumentException(
                sprintf('Provided $id is not and instance of %s', UserId::class)
            );
        }
    }

    /**
     * @param UserId $id
     *
     * @return mixed
     */
    protected function identityToArray($id)
    {
        return [
            (string) $id
        ];
    }
}
