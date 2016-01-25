<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/16/15
 * Time: 1:58 AM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository\Contracts;

interface WriteRepository extends Repository
{
    /**
     * Adds a new entity to the storage.
     *
     * @param Identity $value
     *
     * @return mixed
     */
    public function persist(Identity $value);

    /**
     * Adds a collections of entities to the storage.
     *
     * @param array $values
     *
     * @return mixed
     */
    public function persistAll(array $values);

    /**
     * Deletes the entity with the given id.
     *
     * @param $id
     */
    public function delete(Identity $id);

    /**
     * Deletes all elements in the repository given the restrictions provided by the Filter object.
     * If $filter is null, all the repository data will be deleted.
     *
     * @param Filter $filter
     *
     * @return bool
     */
    public function deleteAll(Filter $filter = null);
}
