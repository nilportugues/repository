<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/16/15
 * Time: 1:28 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\DDDFoundation\Domain\Repository\Collection;

use JsonSerializable;
use SplFixedArray;

/**
 * Class ImmutableCollection
 * @package NilPortugues\DDDFoundation\Domain\Repository
 */
class ImmutableCollection extends SplFixedArray implements JsonSerializable
{
    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return json_encode($this->toArray());
    }
}
