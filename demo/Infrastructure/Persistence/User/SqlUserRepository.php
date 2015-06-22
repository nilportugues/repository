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
use PhpDdd\Demo\Infrastructure\Persistence\SqlRepository;
use PhpDdd\Foundation\Domain\Repository\CrudRepository;
use PhpDdd\Foundation\Domain\Repository\Filter;
use PhpDdd\Foundation\Domain\Repository\Page;
use PhpDdd\Foundation\Domain\Repository\Pageable;
use PhpDdd\Foundation\Domain\Repository\Sort;

class SqlUserRepository extends SqlRepository implements CrudRepository
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

    ];

    /**
     * Returns the next identity value.
     *
     * @return mixed
     */
    public function nextIdentity()
    {
        return new UserId();
    }

    /**
     * Adds a new entity to the storage.
     *
     * @param User $value
     *
     * @return mixed
     */
    public function add($value)
    {
        $this->guardForUser($value);

        return [
            'INSERT INTO users(user_id, name, email, birthdate) VALUES(?, ?, ?, ?);',
            [
                (string) $value->userId(),
                (string) $value->name(),
                (string) $value->email(),
                (string) $value->birthdate()
            ]
        ];
    }

    /**
     * @param $value
     *
     * @throws \InvalidArgumentException
     */
    private function guardForUser($value)
    {
        if (false === ($value instanceof User)) {
            throw new InvalidArgumentException(
                sprintf('Provided $value is not and instance of %s', User::class)
            );
        }
    }

    /**
     * Adds a collections of entities to the storage.
     *
     * @param array $values
     *
     * @return mixed
     */
    public function addAll(array $values)
    {
        $sqlArray = [];
        $bindingsArray = [];

        foreach ($values as &$value) {
            list($sql, $bindings) = $this->add($value);
            $sqlArray = array_merge($sqlArray, $sql);
            $bindingsArray = array_merge($bindingsArray, $bindings);
        }

        return [
            implode(PHP_EOL, $sqlArray),
            $bindingsArray
        ];
    }

    /**
     * Updates one element in the repository with the given $values.
     *
     * @param UserId  $id
     * @param array|object $values
     *
     * @return mixed
     */
    public function update($id, $values)
    {
        $this->guardForUserId($id);

        return [
            'UPDATE users SET users.name = ?, users.email = ? WHERE users.user_id = ? LIMIT 1;',
            array_merge([(string) $id], (array) $values)
        ];
    }

    /**
     * Updates all elements in the repository with the given $values, given the restrictions
     * provided by the Filter object.
     *
     * @param Filter       $filter
     * @param array|object $values
     *
     * @return array
     */
    public function updateAll(Filter $filter, $values)
    {
        list($filtersAsSql, $bindings) = $this->filtersToSql($filter);

        return [
            sprintf('UPDATE users SET users.name = ?, users.email = ?%s;', $filtersAsSql),
            array_merge((array) $values, $bindings)
        ];
    }

    /**
     * Returns all instances of the type.
     *
     * @param Filter $filter
     * @param Sort   $sort
     *
     * @return array
     */
    public function findBy(Filter $filter = null, Sort $sort = null)
    {
        list($filtersAsSql, $bindings) = $this->filtersToSql($filter);

        return [
            sprintf('SELECT * FROM users%s%s;', $filtersAsSql, $this->sortToSql($sort)),
            $bindings
        ];
    }

    /**
     * Returns a Page of entities meeting the paging restriction provided in the Pageable object.
     *
     * @param Pageable $pageable
     *
     * @return Page
     */
    public function findAll(Pageable $pageable)
    {
        list($filtersAsSql, $bindings) = $this->filtersToSql($pageable->getFilter());

        return [
            sprintf(
                'SELECT * FROM users%s%s LIMIT %s OFFSET %s;',
                $filtersAsSql,
                $this->sortToSql($pageable->getSort()),
                $pageable->getPageSize(),
                $pageable->getOffset()
            ),
            $bindings
        ];
    }

    /**
     * Returns the total amount of elements in the repository given the restrictions provided by the Filter object.
     *
     * @param Filter|null $filter
     *
     * @return array
     */
    public function count(Filter $filter = null)
    {
        list($filtersAsSql, $bindings) = $this->filtersToSql($filter);

        return [
            sprintf('SELECT COUNT(user_id) FROM users%s LIMIT 1;', $filtersAsSql),
            $bindings
        ];
    }

    /**
     * Returns whether an entity with the given id exists.
     *
     * @param UserId $id
     *
     * @return array
     */
    public function exists($id)
    {
        return $this->find($id);
    }

    /**
     * Retrieves an entity by its id.
     *
     * @param UserId $id
     *
     * @return array
     */
    public function find($id)
    {
        $this->guardForUserId($id);

        return [
            'SELECT * FROM users WHERE user_id = ? LIMIT 1;',
            [(string)$id]
        ];
    }

    /**
     * @param UserId $id
     *
     * @throws InvalidArgumentException
     */
    private function guardForUserId($id)
    {
        if (false === ($id instanceof UserId)) {
            throw new InvalidArgumentException(
                sprintf('Provided $id is not and instance of %s', UserId::class)
            );
        }
    }

    /**
     * Deletes the entity with the given id.
     *
     * @param UserId $id
     *
     * @return array
     */
    public function delete($id)
    {
        $this->guardForUserId($id);

        return [
            'DELETE FROM users WHERE user_id = ? LIMIT 1;',
            [(string)$id]
        ];
    }

    /**
     * Deletes all elements in the repository given the restrictions provided by the Filter object.
     * If $filter is null, all the repository data will be deleted.
     *
     * @param Filter $filter
     *
     * @return array
     */
    public function deleteAll(Filter $filter = null)
    {
        list($filtersAsSql, $bindings) = $this->filtersToSql($filter);

        return [
            sprintf('DELETE FROM users%s;', $filtersAsSql),
            $bindings
        ];
    }
}
