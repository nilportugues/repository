<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/19/15
 * Time: 8:18 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Tests\Foundation\Domain\Model\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\BaseFilter;
use NilPortugues\Foundation\Domain\Model\Repository\Filter;

class FilterTest extends \PHPUnit_Framework_TestCase
{
    public function testMustReturnsABaseFilter()
    {
        $filter = new Filter();
        $this->assertInstanceOf(BaseFilter::class, $filter->must());
    }

    public function testMustNotReturnsABaseFilter()
    {
        $filter = new Filter();
        $this->assertInstanceOf(BaseFilter::class, $filter->mustNot());
    }

    public function testShouldReturnsABaseFilter()
    {
        $filter = new Filter();
        $this->assertInstanceOf(BaseFilter::class, $filter->should());
    }

    public function testItReturnsFilters()
    {
        $filter = new Filter();
        $filter->must()->equal('id', 1);

        $expected = [
            'must' => [
                'equals' => [
                    'id' => [1],
                ],
                'be_empty' => [],
                'be_not_empty' => [],
            ],
            'must_not' => [
                'be_empty' => [],
                'be_not_empty' => [],
            ],
            'should' => [
                'be_empty' => [],
                'be_not_empty' => [],
            ],
        ];

        $this->assertEquals($expected, $filter->filters());
    }

    public function testItReturnsEmptyFilters()
    {
        $filter = new Filter();
        $filter->must()->equal('id', 1);
        $filter->clear();

        $expected = [
            'must' => [
                'be_empty' => [],
                'be_not_empty' => [],
            ],
            'must_not' => [
                'be_empty' => [],
                'be_not_empty' => [],
            ],
            'should' => [
                'be_empty' => [],
                'be_not_empty' => [],
            ],
        ];

        $this->assertEquals($expected, $filter->filters());
    }
}
