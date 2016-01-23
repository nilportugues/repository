<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/16/15
 * Time: 12:39 AM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Foundation\Domain\Model\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\Collections\ImmutableTypedCollection;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\BaseFilter as BaseFilterInterface;
use NilPortugues\Foundation\Domain\Model\Repository\Contracts\Filter as FilterInterface;

class Filter implements FilterInterface
{
    /**
     * @var BaseFilterInterface[]
     */
    protected $filters;

    /**
     *
     */
    public function __construct()
    {
        $this->filters = new ImmutableTypedCollection(3);
    }

    /**
     * @return array
     */
    public function filters()
    {
        return [
            'must'     => $this->must()->get(),
            'must_not' => $this->mustNot()->get(),
            'should'   => $this->should()->get(),
        ];
    }

    /**
     * @return BaseFilterInterface
     */
    public function must()
    {
        return $this->getCollection(self::MUST);
    }

    /**
     * @param $name
     *
     * @return BaseFilterInterface
     */
    protected function getCollection($name)
    {
        if (empty($this->filters[$name])) {
            $this->filters[$name] = new BaseFilter();
        }

        return $this->filters[$name];
    }

    /**
     * @return BaseFilterInterface
     */
    public function mustNot()
    {
        return $this->getCollection(self::MUST_NOT);
    }

    /**
     * @return BaseFilterInterface
     */
    public function should()
    {
        return $this->getCollection(self::SHOULD);
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->clearCollection(self::MUST);
        $this->clearCollection(self::MUST_NOT);
        $this->clearCollection(self::SHOULD);

        return $this;
    }

    /**
     * @param $name
     */
    protected function clearCollection($name)
    {
        if (false === empty($this->filters[$name])) {
            $this->filters[$name]->clear();
        }
    }
}
