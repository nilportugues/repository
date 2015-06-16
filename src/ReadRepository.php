<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/15/15
 * Time: 11:06 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\DDDFoundation\Domain\Repository;

interface ReadRepository
{
    /**
     * Returns a Page of entities meeting the paging restriction provided in the Pageable object.
     *
     * @param Pageable $pageable
     *
     * @return Page
     */
    public function findAll(Pageable $pageable);

    /**
     * Returns the total amount of elements in the repository given the restrictions provided by the Filter object.
     * @param Filter|null $filter
     *
     * @return int
     */
    public function count(Filter $filter = null);
}
