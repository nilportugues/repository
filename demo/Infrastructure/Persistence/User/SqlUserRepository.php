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

use PhpDdd\Demo\Domain\User\User;
use PhpDdd\Demo\Domain\User\UserId;
use PhpDdd\Foundation\Infrastructure\Persistence\Repository\Sql\SqlEntityRepository;

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
     * @var string
     */
    protected $entityClass = User::class;

    /**
     * @var string
     */
    protected $entityIdClass = UserId::class;

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
