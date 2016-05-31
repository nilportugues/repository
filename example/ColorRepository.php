<?php

namespace NilPortugues\Example\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Fields;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Identity;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Page;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Pageable;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Sort;
use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\InMemoryRepository;

class ColorRepository extends InMemoryRepository
{
    /**
     * Returns a Color.
     *
     * @param Color|Identity $id
     * @param Fields|null    $fields
     *
     * @throws ColorNotFoundException
     *
     * @return Color
     */
    public function find(Identity $id, Fields $fields = null)
    {
        $result = parent::find($id, $fields);

        if (null === $result) {
            throw new ColorNotFoundException($id);
        }

        return $result;
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
    public function findBy(Filter $filter = null, Sort $sort = null, Fields $fields = null) : array
    {
        return parent::findBy($filter, $sort, $fields);
    }

    /**
     * Adds or modifies a Color.
     *
     * @param Color|Identity $value
     *
     * @throws ColorNotFoundException
     */
    public function add(Identity $value)
    {
        parent::add($value);
    }

    /**
     * Remove a Color.
     *
     * @param Color|Identity $id
     *
     * @throws ColorNotFoundException
     */
    public function remove(Identity $id)
    {
        $result = parent::find($id);

        if (null === $result) {
            throw new ColorNotFoundException();
        }

        parent::remove($id);
    }

    /**
     * Returns a Page of entities meeting the paging restriction provided in the Pageable object.
     *
     * @param Pageable $pageable
     *
     * @return Page
     */
    public function findAll(Pageable $pageable = null) : Page
    {
        return parent::findAll($pageable);
    }

    /**
     * Returns the total amount of elements in the repository given the restrictions provided by the Filter object.
     *
     * @param Filter|null $filter
     *
     * @return int
     */
    public function count(Filter $filter = null) : int
    {
        return parent::count($filter);
    }

    /**
     * Returns whether an entity with the given id exists.
     *
     * @param Color|Identity $id
     *
     * @return bool
     */
    public function exists(Identity $id) : bool
    {
        return parent::exists($id);
    }

    /**
     * Adds a collections of entities to the storage.
     *
     * @param array $values
     */
    public function addAll(array $values)
    {
        foreach ($values as $value) {
            $this->add($value);
        }
    }

    /**
     * Removes all elements in the repository given the restrictions provided by the Filter object.
     * If $filter is null, all the repository data will be removed.
     *
     * @param Filter $filter
     */
    public function removeAll(Filter $filter = null)
    {
        if (null === $filter) {
            $this->data = [];
        }

        /** @var Identity $value */
        foreach ($this->findBy($filter) as $value) {
            $this->remove($value->id());
        }
    }
}
