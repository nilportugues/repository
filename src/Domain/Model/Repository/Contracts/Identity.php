<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 18/01/16
 * Time: 23:12.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository\Contracts;

/**
 * Class Identity.
 */
interface Identity
{
    /**
     * @return mixed
     */
    public function id();

    /**
     * @return string
     */
    public function __toString();
}
