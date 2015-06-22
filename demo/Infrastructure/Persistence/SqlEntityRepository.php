<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/22/15
 * Time: 12:34 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Demo\Infrastructure\Persistence;

use PhpDdd\Foundation\Domain\Repository\CrudRepository;
use PhpDdd\Foundation\Domain\Repository\Filter;
use PhpDdd\Foundation\Domain\Repository\Page;
use PhpDdd\Foundation\Domain\Repository\Pageable;
use PhpDdd\Foundation\Domain\Repository\Sort;
use RuntimeException;

/**
 * Class SqlEntityRepository
 * @package PhpDdd\Demo\Infrastructure\Persistence
 */
abstract class SqlEntityRepository extends SqlRepository implements CrudRepository
{
    /**
     * @var string
     */
    protected $tableName = '';

    /**
     * @var array
     */
    protected $primaryKey = [];

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @return array
     * @throws \RuntimeException
     */
    public function getColumns()
    {
        if (empty($this->columns) || false === is_array($this->columns)) {
            throw new RuntimeException(
                sprintf(
                    'No valid columns array has been defined for repository %s.',
                    __CLASS__
                )
            );
        }

        return $this->columns;
    }

    /**
     * Returns the next identity value.
     *
     * @return mixed
     */
    abstract public function nextIdentity();

    /**
     * Adds a collections of entities to the storage.
     *
     * @param array $values
     *
     * @return mixed
     */
    public function addAll(array $values)
    {
        $sqlArray      = [];
        $bindingsArray = [];

        foreach ($values as &$value) {
            list($sql, $bindings) = $this->add($value);
            $sqlArray      = array_merge($sqlArray, $sql);
            $bindingsArray = array_merge($bindingsArray, $bindings);
        }

        return [
            implode(PHP_EOL, $sqlArray),
            $bindingsArray
        ];
    }

    /**
     * Adds a new entity to the storage.
     *
     * @param object $value
     *
     * @return mixed
     */
    public function add($value)
    {
        $this->guardForEntity($value);

        return [
            sprintf(
                'INSERT INTO %s(user_id, name, email, birthdate) VALUES(?, ?, ?, ?);',
                $this->getTableName()
            ),
            $this->entityToArray($value)
        ];
    }

    /**
     * @param $value
     *
     * @throws \InvalidArgumentException
     */
    abstract protected function guardForEntity($value);

    /**
     * @throws \RuntimeException
     * @return string
     */
    public function getTableName()
    {
        if (empty($this->tableName) || false === is_string($this->tableName)) {
            throw new RuntimeException(
                sprintf(
                    'No valid table name has been set for repository %s.',
                    __CLASS__
                )
            );
        }

        return $this->tableName;
    }

    /**
     * @param object $value
     *
     * @return mixed
     */
    abstract protected function entityToArray($value);

    /**
     * Updates one element in the repository with the given $values.
     *
     * @param object       $id
     * @param array|object $values
     *
     * @return mixed
     */
    public function update($id, $values)
    {
        $this->guardForIdentity($id);

        return [
            sprintf(
                'UPDATE %s SET users.name = ?, users.email = ? WHERE users.user_id = ? LIMIT 1;',
                $this->getTableName()
            ),
            array_merge($this->identityToArray($id), (array)$values)
        ];
    }

    /**
     * @param $id
     *
     * @throws \InvalidArgumentException
     */
    abstract protected function guardForIdentity($id);

    /**
     * @param object $id
     *
     * @return mixed
     */
    abstract protected function identityToArray($id);

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
            sprintf(
                'UPDATE %s SET users.name = ?, users.email = ?%s;',
                $this->getTableName(),
                $filtersAsSql
            ),
            array_merge((array)$values, $bindings)
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
            sprintf(
                'SELECT * FROM %s%s%s;',
                $this->getTableName(),
                $filtersAsSql,
                $this->sortToSql($sort)
            ),
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
                'SELECT * FROM %s%s%s LIMIT %s OFFSET %s;',
                $this->getTableName(),
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
            sprintf(
                'SELECT COUNT(%s) FROM %s%s LIMIT 1;',
                implode(', ', $this->getPrimaryKey()),
                $this->getTableName(),
                $filtersAsSql
            ),
            $bindings
        ];
    }

    /**
     * @return array
     * @throws \RuntimeException
     */
    public function getPrimaryKey()
    {
        if (empty($this->tableName)) {
            throw new RuntimeException(
                sprintf(
                    'No primary key column/s have been defined for repository %s.',
                    __CLASS__
                )
            );
        }

        return (is_array($this->primaryKey)) ? $this->primaryKey : [$this->primaryKey];
    }

    /**
     * Returns whether an entity with the given id exists.
     *
     * @param object $id
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
     * @param object $id
     *
     * @return array
     */
    public function find($id)
    {
        $this->guardForIdentity($id);

        return [
            sprintf(
                'SELECT * FROM %s WHERE user_id = ? LIMIT 1;',
                $this->getTableName()
            ),
            $this->identityToArray($id)
        ];
    }

    /**
     * Deletes the entity with the given id.
     *
     * @param object $id
     *
     * @return array
     */
    public function delete($id)
    {
        $this->guardForIdentity($id);

        return [
            sprintf(
                'DELETE FROM %s WHERE user_id = ? LIMIT 1;',
                $this->getTableName()
            ),
            $this->identityToArray($id)
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
            sprintf(
                'DELETE FROM %s%s;',
                $this->getTableName(),
                $filtersAsSql
            ),
            $bindings
        ];
    }
}
