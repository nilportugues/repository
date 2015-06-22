<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/16/15
 * Time: 1:58 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Foundation\Domain\Repository;

interface WriteRepository extends Repository
{
    /**
     * Returns the next identity value.
     *
     * @return mixed
     */
    public function nextIdentity();

    /**
     * Adds a new entity to the storage.
     *
     * @param array|object $value
     *
     * @return mixed
     */
    public function add($value);

    /**
     * Adds a collections of entities to the storage.
     *
     * @param array $values
     *
     * @return mixed
     */
    public function addAll(array $values);

    /**
     * Deletes the entity with the given id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function delete($id);

    /**
     * Deletes all elements in the repository given the restrictions provided by the Filter object.
     * If $filter is null, all the repository data will be deleted.
     *
     * @param Filter $filter
     *
     * @return mixed
     */
    public function deleteAll(Filter $filter = null);
}
