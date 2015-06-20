<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/19/15
 * Time: 6:39 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Foundation\Domain\Repository;

interface CrudRepository extends ReadRepository, WriteRepository
{
    /**
     * Updates all elements in the repository with the given $values, given the restrictions
     * provided by the Filter object.
     *
     * @param Filter       $filter
     * @param array|object $values
     *
     * @return void
     */
    public function updateAll(Filter $filter, $values);
}
