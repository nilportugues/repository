<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/21/15
 * Time: 1:43 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Foundation\Infrastructure\Persistence\Repository\Sql\Pdo;

use PDO;
use PhpDdd\Foundation\Domain\Repository\CrudRepository;
use PhpDdd\Foundation\Domain\Repository\Filter;
use PhpDdd\Foundation\Domain\Repository\Page;
use PhpDdd\Foundation\Domain\Repository\Pageable;
use PhpDdd\Foundation\Domain\Repository\Sort;
use RuntimeException;

class PdoSqlRepository implements CrudRepository
{
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var CrudRepository
     */
    private $sqlRepository;

    /**
     * @param PDO            $pdo
     * @param CrudRepository $sqlRepository
     */
    public function __construct(PDO $pdo, CrudRepository $sqlRepository)
    {
        $this->pdo           = $pdo;
        $this->sqlRepository = $sqlRepository;
    }

    /**
     * Returns the next identity value.
     *
     * @return object
     */
    public function nextIdentity()
    {
        return $this->sqlRepository->nextIdentity();
    }

    /**
     * Adds a new entity to the storage.
     *
     * @param array|object $value
     *
     * @return object
     */
    public function add($value)
    {
        list($sql, $bindings) = $this->sqlRepository->add($value);

        $this->prepareAndExecute($sql, $bindings);

        return $value;
    }

    /**
     * @param string $sql
     * @param array $bindings
     *
     * @return \PDOStatement
     */
    private function prepareAndExecute($sql, array &$bindings)
    {
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($bindings);

        return $stmt;
    }

    /**
     * Adds a collections of entities to the storage.
     *
     * @param array $values
     *
     * @throws RuntimeException
     * @return array
     */
    public function addAll(array $values)
    {
        $this->mustBeTransactionalGuard();

        foreach ($values as $value) {
            list($sql, $bindings) = $this->sqlRepository->add($value);
            $this->prepareAndExecute($sql, $bindings);
        }
        return $values;
    }

    /**
     * @throws \RuntimeException
     */
    protected function mustBeTransactionalGuard()
    {
        if (false === $this->pdo->inTransaction()) {
            throw new RuntimeException('This operation should be run inside a PDO transaction');
        }
    }

    /**
     * @param object       $id
     * @param array|object $values
     *
     * @return array
     */
    public function update($id, $values)
    {
        list($sql, $bindings) = $this->sqlRepository->update($id, $values);

        $this->prepareAndExecute($sql, $bindings);

        return $this->find($id);
    }

    /**
     * @param object $id
     *
     * @return array
     */
    public function find($id)
    {
        list($sql, $bindings) = $this->sqlRepository->find($id);

        $stmt = $this->prepareAndExecute($sql, $bindings);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param Filter       $filter
     * @param array|object $values
     *
     * @return array
     */
    public function updateAll(Filter $filter, $values)
    {
        $this->mustBeTransactionalGuard();

        list($sql, $bindings) = $this->sqlRepository->updateAll($filter, $values);

        $this->prepareAndExecute($sql, $bindings);

        return $values;
    }

    /**
     * @param Filter $filter
     * @param Sort   $sort
     *
     * @return array
     */
    public function findBy(Filter $filter = null, Sort $sort = null)
    {
        list($sql, $bindings) = $this->sqlRepository->findBy($filter, $sort);

        $stmt = $this->prepareAndExecute($sql, $bindings);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        list($sql, $bindings) = $this->sqlRepository->findAll($pageable);

        $stmt = $this->prepareAndExecute($sql, $bindings);

        $count = $this->count($pageable->getFilter());

        return new Page(
            $stmt->fetchAll(PDO::FETCH_ASSOC),
            $count,
            $pageable->getPageNumber(),
            ceil($count / $pageable->getPageSize()),
            $pageable->getSort(),
            $pageable->getFilter()
        );
    }

    /**
     * @param Filter $filter
     *
     * @return int
     */
    public function count(Filter $filter = null)
    {
        list($sql, $bindings) = $this->sqlRepository->count($filter);

        $stmt = $this->prepareAndExecute($sql, $bindings);

        return (int)$stmt->fetch(PDO::FETCH_COLUMN, 0);
    }

    /**
     * @param object $id
     *
     * @return bool
     */
    public function exists($id)
    {
        list($sql, $bindings) = $this->sqlRepository->exists($id);

        $stmt = $this->prepareAndExecute($sql, $bindings);
        $result = $stmt->fetch(PDO::FETCH_COLUMN, 0);

        return empty($result);
    }

    /**
     * @param object $id
     *
     * @return void
     */
    public function delete($id)
    {
        list($sql, $bindings) = $this->sqlRepository->delete($id);

        $this->prepareAndExecute($sql, $bindings);
    }

    /**
     * @param Filter $filter
     *
     * @return void
     */
    public function deleteAll(Filter $filter = null)
    {
        list($sql, $bindings) = $this->sqlRepository->deleteAll($filter);

        $this->prepareAndExecute($sql, $bindings);
    }
}
