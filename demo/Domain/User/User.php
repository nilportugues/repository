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
 * Class User
 * @package PhpDdd\Demo\Domain\User
 */
class User
{
    /**
     * @var UserId
     */
    private $userId;
    /**
     * @var UserName
     */
    private $name;
    /**
     * @var UserEmail
     */
    private $email;

    /**
     * @param UserId    $userId
     * @param UserName  $name
     * @param UserEmail $email
     * @param BirthDate $birthDate
     */
    public function __construct(UserId $userId, UserName $name, UserEmail $email, BirthDate $birthDate)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->email = $email;
        $this->birthdate = $birthDate;
    }

    /**
     * @return BirthDate
     */
    public function birthDate()
    {
        return $this->birthdate;
    }

    /**
     * @return UserEmail
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return UserName
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return UserId
     */
    public function userId()
    {
        return $this->userId;
    }
}
