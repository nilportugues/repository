<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/21/15
 * Time: 2:14 PM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Demo\Domain\User;

use DateTime;

final class BirthDate extends DateTime
{
    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->format('Y-m-d');
    }

    /**
     * Returns the age as an integer given the current date
     *
     * @return int
     */
    public function age()
    {
        $now = new DateTime('now');
        $age = $now->diff($this, true);

        return (int) $age->format('%Y');
    }
}
