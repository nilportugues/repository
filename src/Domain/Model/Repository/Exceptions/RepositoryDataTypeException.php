<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/01/16
 * Time: 19:26.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository\Exceptions;

class RepositoryDataTypeException extends \InvalidArgumentException
{
    /**
     * RepositoryDataTypeException constructor.
     *
     * @param string          $type
     * @param mixed           $variable
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct(string $type, $variable, int $code = 0, \Exception $previous = null)
    {
        $message = sprintf(
            'Expected variable of type \'%s\', but got a variable of type \'%s\' instead.',
            $type,
            (is_object($variable)) ? get_class($variable) : gettype($variable)
        );

        parent::__construct($message, $code, $previous);
    }
}
