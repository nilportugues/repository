<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 7/02/16
 * Time: 17:01.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository\Contracts;

interface Mapping
{
    /**
     * Returns the name of the collection or table.
     *
     * @return string
     */
    public function name();

    /**
     * Keys are object properties without property defined in identity().
     * Values its equivalents in the data store.
     *
     * @return array
     */
    public function map();

    /**
     * Name of the identity field in storage.
     *
     * @return string
     */
    public function identity();


    /**
     * @param array $data
     *
     * @return mixed
     */
    public function fromArray(array $data);

    /**
     * @param $object
     *
     * @return array
     */
    public function toArray($object);
    
        /**
     * The automatic generated strategy used will be the data-store's if set to true.
     *
     * @return bool
     */
    public function autoGenerateId();
}
