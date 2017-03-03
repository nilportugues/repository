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

    public function testItShouldAddFilterForNotStartsWith()
    {
        $this->filter->notStartsWith('name', 'N');

        $expected = [
            'not_starts' => [
                'name' => ['N'],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForNotEndsWith()
    {
        $this->filter->notEndsWith('name', 'N');

        $expected = [
            'not_ends' => [
                'name' => ['N'],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForEmpty()
    {
        $this->filter->empty('name');

        $expected = [
            'empty' => [
                'name' => ['empty'],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForNotEmpty()
    {
        $this->filter->notEmpty('name');

        $expected = [
            'not_empty' => [
                'name' => ['not_empty'],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForHasEmpty()
    {
        $this->filter->hasEmpty('name');

        $expected = [
            'empty' => [
                'name' => ['empty'],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForNull()
    {
        $this->filter->null('name');

        $expected = [
            'null' => [
                'name' => ['null'],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForNotNull()
    {
        $this->filter->notNull('name');

        $expected = [
            'not_null' => [
                'name' => ['not_null'],
            ],
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
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForEquals()
    {
        $this->filter->equal('name', 'Nil');

        $expected = [
            'equals' => [
                'name' => ['Nil'],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForNotEquals()
    {
        $this->filter->notEqual('name', 'Nil');

        $expected = [
            'not_equals' => [
                'name' => ['Nil'],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForIncludesGroup()
    {
        $this->filter->includeGroup('name', ['Nil', 'Juan']);

        $expected = [

            'group' => [
                'name' => ['Nil', 'Juan'],

            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForRangesBetween()
    {
        $this->filter->range('age', 18, 50);

        $expected = [
            'ranges' => [
                'age' => [
                    [18, 50],
                ],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForNotRangesBetween()
    {
        $this->filter->notRange('age', 18, 50);

        $expected = [
            'not_ranges' => [
                'age' => [
                    [18, 50],
                ],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForNotContains()
    {
        $this->filter->notContain('name', 'Nil');

        $expected = [
            'not_contains' => [
                'name' => ['Nil'],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForContains()
    {
        $this->filter->contain('name', 'N');

        $expected = [
            'contains' => [
                'name' => ['N'],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForGreaterThanOrEqual()
    {
        $this->filter->beGreaterThanOrEqual('age', 18);

        $expected = [
            'gte' => [
                'age' => [18],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForGreaterThan()
    {
        $this->filter->beGreaterThan('age', 18);

        $expected = [
            'gt' => [
                'age' => [18],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForLessThanOrEqual()
    {
        $this->filter->beLessThanOrEqual('age', 18);

        $expected = [
            'lte' => [
                'age' => [18],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldAddFilterForLessThan()
    {
        $this->filter->beLessThan('age', 18);

        $expected = [
            'lt' => [
                'age' => [18],
            ],
        ];

        $this->assertEquals($expected, $this->filter->get());
    }

    public function testItShouldClearAllFilters()
    {
        $current = $this->filter->get();

        $this->filter->beGreaterThan('publication_date', 2000);
        $this->filter->clear();

        $this->assertEquals($current, $this->filter->get());
    }

    protected function setUp()
    {
        $this->filter = new BaseFilter();
    }
}
