<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/15/15
 * Time: 11:06 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Foundation\Domain\Repository;

interface ReadRepository extends Repository
{
    /**
     * Retrieves an entity by its id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function findOne($id);

    /**
     * Returns all instances of the type.
     *
     * @param Sort   $sort
     * @param Filter $filter
     *
     * @return mixed
     */
    public function findAll(Sort $sort = null, Filter $filter = null);
}
