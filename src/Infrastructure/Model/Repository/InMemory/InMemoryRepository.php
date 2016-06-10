<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 25/01/16
 * Time: 19:19.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory;

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Fields;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter as FilterInterface;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Identity;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Page;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Pageable;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\PageRepository;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\ReadRepository;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Sort;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\WriteRepository;
use NilPortugues\Foundation\Domain\Model\Repository\Page as ResultPage;
use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\Filter as InMemoryFilter;

class InMemoryRepository implements ReadRepository, WriteRepository, PageRepository
{
    /**
     * @var Identity[]
     */
    protected $data = [];

    /**
     * NameRepository constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        foreach($data as $item) {
            $this->add($item);
        }
    }

    /**
     * Returns a Page of entities meeting the paging restriction provided in the Pageable object.
     *
     * @param Pageable $pageable
     *
     * @return Page
     */
    public function findAll(Pageable $pageable = null): Page
    {
        if (null === $pageable) {
            return new ResultPage($this->data, count($this->data), 1, 1);
        }

        $results = $this->findBy($pageable->filters(), $pageable->sortings());

        if (0 !== count($pageable->distinctFields()->get())) {
            $results = $this->resultsWithDistinctFieldsOnly($pageable->distinctFields(), $results);
        }

        $pageSize = ($pageable->pageSize()) ? $pageable->pageSize() : 1;
        
        return new ResultPage(
            array_slice($results, $pageable->offset() - $pageable->pageSize(), $pageable->pageSize()),
            count($results),
            $pageable->pageNumber(),
            ceil(count($results) / $pageSize)
        );
    }

    /**
     * Returns the total amount of elements in the repository given the restrictions provided by the Filter object.
     *
     * @param FilterInterface|null $filter
     *
     * @return int
     */
    public function count(FilterInterface $filter = null): int
    {
        if (null === $filter) {
            return count($this->data);
        }

        return count($this->findBy($filter));
    }

    /**
     * Returns whether an entity with the given id exists.
     *
     * @param Identity $id
     *
     * @return bool
     */
    public function exists(Identity $id): bool
    {
        $id = (string) $id;

        return array_key_exists($id, $this->data);
    }

    /**
     * Adds a new entity to the storage.
     *
     * @param Identity $value
     *
     * @return mixed
     */
    public function add(Identity $value)
    {
        $id = (string) $value->id();
        $this->data[$id] = clone $value;
        
        return clone $value;
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
        foreach ($values as $value) {
            $this->add($value);
        }
    }

    /**
     * Removes the entity with the given id.
     *
     * @param Identity $id
     */
    public function remove(Identity $id)
    {
        if ($this->exists($id)) {
            unset($this->data[$id->id()]);
        }
    }

    /**
     * Removes all elements in the repository given the restrictions provided by the Filter object.
     * If $filter is null, all the repository data will be removed.
     *
     * @param FilterInterface $filter
     */
    public function removeAll(FilterInterface $filter = null)
    {
        if (null === $filter) {
            $this->data = [];
        }
        /** @var Identity $value */
        foreach ($this->findBy($filter) as $value) {
            unset($this->data[$value->id()]);
        }
    }

    /**
     * Retrieves an entity by its id.
     *
     * @param Identity    $id
     * @param Fields|null $fields
     *
     * @return array
     */
    public function find(Identity $id, Fields $fields = null)
    {
        if (false === $this->exists($id)) {
            return;
        }

        return clone $this->data[(string) $id];
    }

    /**
     * Returns all instances of the type.
     *
     * @param FilterInterface|null $filter
     * @param Sort|null            $sort
     * @param Fields|null          $fields
     *
     * @return array
     */
    public function findBy(FilterInterface $filter = null, Sort $sort = null, Fields $fields = null): array
    {
        $results = $this->data;

        if (null !== $filter && !$filter->isNull()) {
            $results = InMemoryFilter::filter($results, $filter);
        }

        if (null !== $sort && !$filter->isNull()) {
            $results = Sorter::sort($results, $sort);
        }

        return array_values($results);
    }

    /**
     * Repository data is added or removed as a whole block.
     * Must work or fail and rollback any persisted/erased data.
     *
     * @param callable $transaction
     *
     * @throws \Exception
     */
    public function transactional(callable $transaction)
    {
        $copy = $this->data;
        try {
            $transaction();
        } catch (\Exception $e) {
            $this->data = $copy;
            throw $e;
        }
    }

    /**
     * Returns all instances of the type meeting $distinctFields values.
     *
     * @param Fields               $distinctFields
     * @param FilterInterface|null $filter
     * @param Sort|null            $sort
     *
     * @return array
     */
    public function findByDistinct(Fields $distinctFields, FilterInterface $filter = null, Sort $sort = null): array
    {
        $results = $this->findBy($filter, $sort, $distinctFields);

        return $this->resultsWithDistinctFieldsOnly($distinctFields, $results);
    }

    /**
     * @param Fields $distinctFields
     * @param        $results
     *
     * @return array
     *
     * @throws \Exception
     */
    protected function resultsWithDistinctFieldsOnly(Fields $distinctFields, $results): array
    {
        $newResults = [];
        $valueHash = [];
        foreach ($results as $result) {
            $distinctValues = [];
            foreach ($distinctFields->get() as $field) {
                $distinctValues[$field] = PropertyValue::get($result, $field);
            }

            $hash = md5(serialize($distinctValues));
            if (false === in_array($hash, $valueHash)) {
                $valueHash[] = $hash;
                $newResults[] = $result;
            }
        }

        return $newResults;
    }
}
