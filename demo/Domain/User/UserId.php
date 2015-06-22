<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/21/15
 * Time: 1:41 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Demo\Domain\User;

/**
 * Class UserId
 * @package PhpDdd\Demo\Domain\User
 */
final class UserId
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @param $userId
     */
    public function __construct($userId = null)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->userId;
    }
}
