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
        $this->data = $data;
    }

    /**
     * Returns a Page of entities meeting the paging restriction provided in the Pageable object.
     *
     * @param Pageable $pageable
     *
     * @return Page
     */
    public function findAll(Pageable $pageable = null)
    {
        if (null === $pageable) {
            return new ResultPage($this->data, count($this->data), 1, 1);
        }

        $results = $this->findBy($pageable->filters(), $pageable->sortings());

        return new ResultPage(
            array_slice($results, $pageable->offset() - $pageable->pageSize(), $pageable->pageSize()),
            count($results),
            $pageable->pageNumber(),
            ceil(count($results) / $pageable->pageSize())
        );
    }

    /**
     * Returns the total amount of elements in the repository given the restrictions provided by the Filter object.
     *
     * @param FilterInterface|null $filter
     *
     * @return int
     */
    public function count(FilterInterface $filter = null)
    {
        if (null === $filter) {
            return count($this->data);
        }

        return count($this->findBy($filter));
    }

    /**
     * Returns whether an entity with the given id exists.
     *
     * @param $id
     *
     * @return bool
     */
    public function exists(Identity $id)
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
     * @param $id
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
     *
     * @return bool
     */
    public function removeAll(FilterInterface $filter = null)
    {
        if (null === $filter) {
            $this->data = [];

            return true;
        }
        /** @var Identity $value */
        foreach ($this->findBy($filter) as $value) {
            unset($this->data[$value->id()]);
        }

        return true;
    }

    /**
     * Retrieves an entity by its id.
     *
     * @param Identity    $id
     * @param Fields|null $fields
     *
     * @return mixed
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
    public function findBy(FilterInterface $filter = null, Sort $sort = null, Fields $fields = null)
    {
        $results = $this->data;

        if (null !== $filter) {
            $results = InMemoryFilter::filter($results, $filter);
        }

        if (null !== $sort) {
            $results = Sorter::sort($results, $sort);
        }

        return array_values($results);
    }
}
