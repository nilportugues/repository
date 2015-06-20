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
     * Deletes the entity with the given id.
     *
     * @param $id
     *
     * @return void
     */
    public function delete($id);

    /**
     * Deletes all elements in the repository given the restrictions provided by the Filter object.
     * If $filter is null, all the repository data will be deleted.
     *
     * @param Filter $filter
     *
     * @return void
     */
    public function deleteAll(Filter $filter = null);
}
