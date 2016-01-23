<?php

namespace NilPortugues\Example\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Fields;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Identity;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Page;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Pageable;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Sort;
use NilPortugues\Foundation\Domain\Model\Repository\Page as ResultPage;
use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\InMemoryFilter;
use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\InMemorySorter;

class ColorRepository implements ColorRepositoryInterface
{
    /**
     * @var Identity[]
     */
    private $data = [];

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
     * Returns a Color.
     *
     * @param Identity    $id
     * @param Fields|null $fields
     *
     * @throws ColorNotFoundException
     *
     * @return Color
     */
    public function find(Identity $id, Fields $fields = null)
    {
        if (false === $this->exists($id)) {
            throw new ColorNotFoundException($id);
        }

        $id = (string)$id;

        return clone $this->data[$id];
    }

    /**
     * Returns an array of Colors based on the filtering conditions.
     *
     * @param Filter|null $filter
     * @param Sort|null   $sort
     * @param Fields|null $fields
     *
     * @return Color[]
     */
    public function findBy(Filter $filter = null, Sort $sort = null, Fields $fields = null)
    {
        $results = $this->data;

        if (null !== $filter) {
            $results = InMemoryFilter::filter($results, $filter);
        }

        if (null !== $sort) {
            $results = InMemorySorter::sort($results, $sort);
        }

        return array_values($results);
    }

    /**
     * Adds or modifies a Color.
     *
     * @param Color $value
     *
     * @throws ColorNotFoundException
     *
     * @return Color
     */
    public function persist($value)
    {
        $id = (string)$value->id();

        $this->data[$id] = clone $value;
    }

    /**
     * Delete a Color.
     *
     * @param Identity $id
     *
     * @throws ColorNotFoundException
     */
    public function delete(Identity $id)
    {
        if (false === array_key_exists($id->id(), $this->data)) {
            throw new ColorNotFoundException();
        }

        unset($this->data[$id->id()]);
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

        $results = $this->findBy($pageable->getFilter(), $pageable->getSort());

        return new ResultPage(
            array_slice($results, $pageable->getOffset() - 1, $pageable->getPageSize()),
            count($results),
            $pageable->getPageNumber(),
            ceil(count($results) / $pageable->getPageSize())
        );
    }

    /**
     * Returns the total amount of elements in the repository given the restrictions provided by the Filter object.
     *
     * @param Filter|null $filter
     *
     * @return int
     */
    public function count(Filter $filter = null)
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
        $id = (string)$id;

        return array_key_exists($id, $this->data);
    }

    /**
     * Adds a collections of entities to the storage.
     *
     * @param array $values
     *
     * @return mixed
     */
    public function persistAll(array $values)
    {
        foreach ($values as $value) {
            $this->persist($value);
        }
    }

    /**
     * Deletes all elements in the repository given the restrictions provided by the Filter object.
     * If $filter is null, all the repository data will be deleted.
     *
     * @param Filter $filter
     *
     * @return bool
     */
    public function deleteAll(Filter $filter = null)
    {
        if (null === $filter) {
            $this->data = [];

            return true;
        }

        /** @var Identity $value */
        foreach ($this->findBy($filter) as $value) {
            $this->delete($value->id());
        }
        return true;
    }
}
