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
    public function findBy(Filter $filter = null, Sort $sort = null, Fields $fields = null)
    {
        return parent::findBy($filter, $sort, $fields);
    }

    /**
     * Adds or modifies a Color.
     *
     * @param Color|Identity $value
     *
     * @throws ColorNotFoundException
     *
     * @return Color
     */
    public function persist(Identity $value)
    {
        return parent::persist($value);
    }

    /**
     * Delete a Color.
     *
     * @param Color|Identity $id
     *
     * @throws ColorNotFoundException
     */
    public function delete(Identity $id)
    {
        $result = parent::find($id);

        if (null === $result) {
            throw new ColorNotFoundException();
        }

        parent::delete($id);
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
        return parent::findAll($pageable);
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
        return parent::count($filter);
    }

    /**
     * Returns whether an entity with the given id exists.
     *
     * @param Color|Identity $id
     *
     * @return bool
     */
    public function exists(Identity $id)
    {
        return parent::exists($id);
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
        parent::persistAll($values);
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
        return parent::deleteAll($filter);
    }
}
