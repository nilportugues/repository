<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/16/15
 * Time: 1:58 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\DDDFoundation\Domain\Repository;

interface WriteRepository
{

    /**
     * Deletes all elements in the repository given the restrictions provided by the Filter object.
     * @param Filter $filter
     *
     * @return bool
     */
    public function deleteAll(Filter $filter);

    /**
     * Updates all elements in the repository with the given $values, given the restrictions
     * provided by the Filter object.
     *
     * @param Filter       $filter
     * @param array|object $values
     *
     * @return bool
     */
    public function update(Filter $filter, $values);
}
