<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/16/15
 * Time: 12:39 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpDdd\Foundation\Domain\Repository;

use PhpDdd\Foundation\Domain\Repository\Collection\ImmutableTypedCollection;

final class Filter
{
    const MUST     = 0;
    const MUST_NOT = 1;
    const SHOULD   = 2;

    /**
     * @var BaseFilter[]
     */
    private $filters;

    /**
     *
     */
    public function __construct()
    {
        $this->filters = new ImmutableTypedCollection(3);
    }

    /**
     * @return BaseFilter
     */
    public function must()
    {
        return $this->getCollection(self::MUST);
    }

    /**
     * @param $name
     *
     * @return BaseFilter
     */
    private function getCollection($name)
    {
        if (empty($this->filters[$name])) {
            $this->filters[$name] = new BaseFilter();
        }
        return $this->filters[$name];
    }

    /**
     * @return BaseFilter
     */
    public function mustNot()
    {
        return $this->getCollection(self::MUST_NOT);
    }

    /**
     * @return BaseFilter
     */
    public function should()
    {
        return $this->getCollection(self::SHOULD);
    }

    /**
     * @return array
     */
    public function filters()
    {
        return [
            'must' => $this->must()->get(),
            'must_not' => $this->mustNot()->get(),
            'should' => $this->should()->get(),
        ];
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
    private function clearCollection($name)
    {
        if (false === empty($this->filters[$name])) {
            $this->filters[$name]->clear();
        }
    }
}
