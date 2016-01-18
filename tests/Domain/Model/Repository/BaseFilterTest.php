<?php

/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 6/19/15
 * Time: 6:57 PM.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace NilPortugues\Tests\Foundation\Domain\Model\Repository;

use NilPortugues\Foundation\Domain\Model\Repository\BaseFilter;

class BaseFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BaseFilter
     */
    private $filter;

    public function testItShouldAddFilterForNotEmpty()
    {
        $this->filter->notEmpty('name');

        $expected = [
            'be_empty' => [],
            'be_not_empty' => ['name'],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForHasEmpty()
    {
        $this->filter->hasEmpty('name');

        $expected = [
            'be_empty' => ['name'],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForStartsWith()
    {
        $this->filter->startsWith('name', 'N');

        $expected = [
            'start_with' => [
                'name' => ['N'],
            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForEndsWith()
    {
        $this->filter->endsWith('name', 'N');

        $expected = [
            'end_with' => [
                'name' => ['N'],
            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForEquals()
    {
        $this->filter->equals('name', 'Nil');

        $expected = [
            'equals' => [
                'name' => ['Nil'],
            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForNotEquals()
    {
        $this->filter->notEquals('name', 'Nil');

        $expected = [
            'not_equals' => [
                'name' => ['Nil'],
            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForIncludesGroup()
    {
        $this->filter->includesGroup('name', ['Nil', 'Juan']);

        $expected = [

            'group' => [
                'name' => ['Nil', 'Juan'],

            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForRangesBetween()
    {
        $this->filter->ranges('age', 18, 50);

        $expected = [
            'ranges' => [
                'age' => [
                    [18, 50],
                ],
            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForNotRangesBetween()
    {
        $this->filter->notRanges('age', 18, 50);

        $expected = [
            'not_ranges' => [
                'age' => [
                    [18, 50],
                ],
            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForNotContains()
    {
        $this->filter->notContains('name', 'Nil');

        $expected = [
            'not_contains' => [
                'name' => ['Nil'],
            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForContains()
    {
        $this->filter->contains('name', 'N');

        $expected = [
            'contains' => [
                'name' => ['N'],
            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForGreaterThanOrEqual()
    {
        $this->filter->greaterThanOrEqual('age', 18);

        $expected = [
            'gte' => [
                'age' => [18],
            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForGreaterThan()
    {
        $this->filter->greaterThan('age', 18);

        $expected = [
            'gt' => [
                'age' => [18],
            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForLessThanOrEqual()
    {
        $this->filter->lessThanOrEqual('age', 18);

        $expected = [
            'lte' => [
                'age' => [18],
            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForLessThan()
    {
        $this->filter->lessThan('age', 18);

        $expected = [
            'lt' => [
                'age' => [18],
            ],
            'be_empty' => [],
            'be_not_empty' => [],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldClearAllFilters()
    {
        $current = $this->filter->get();

        $this->filter->greaterThan('publication_date', 2000);
        $this->filter->clear();

        $this->assertEquals($current, $this->filter->get());
    }

    protected function setUp()
    {
        $this->filter = new BaseFilter();
    }
}
