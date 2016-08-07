# Repository

![PHP7 Tested](http://php-eye.com/badge/nilportugues/repository/php70.svg)
[![Build Status](https://travis-ci.org/PHPRepository/repository.svg)](https://travis-ci.org/PHPRepository/repository) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nilportugues/repository/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nilportugues/repository/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/428e1f96-bcf4-4dee-866e-7a7cb5db52e4/mini.png)](https://insight.sensiolabs.com/projects/428e1f96-bcf4-4dee-866e-7a7cb5db52e4) [![Latest Stable Version](https://poser.pugx.org/nilportugues/repository/v/stable)](https://packagist.org/packages/nilportugues/repository) [![Total Downloads](https://poser.pugx.org/nilportugues/repository/downloads)](https://packagist.org/packages/nilportugues/repository) [![License](https://poser.pugx.org/nilportugues/repository/license)](https://packagist.org/packages/nilportugues/repository)
[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif)](https://paypal.me/nilportugues)

Generic implementation and definition of a Repository and its in-memory implementation.

## Installation

Use [Composer](https://getcomposer.org) to install the package:

```json
$ composer require nilportugues/repository
```

## InMemory Implementation

A custom repository can be easily created by extending the InMemoryRepository class provided.

```php
use NilPortugues\Foundation\Infrastructure\Model\Repository\InMemory\InMemoryRepository

class MyInMemoryRepository extends InMemoryRepository
{
    //... your custom implementation.
}
```

Implementation can be seen [here](https://github.com/nilportugues/php-repository/blob/master/src/Infrastructure/Model/Repository/InMemory/InMemoryRepository.php). 

The base InMemoryRepository implements the following interfaces:

- `NilPortugues\Foundation\Domain\Model\Repository\Contracts\Repository`
- `NilPortugues\Foundation\Domain\Model\Repository\Contracts\PageRepository`
- `NilPortugues\Foundation\Domain\Model\Repository\Contracts\ReadRepository`
- `NilPortugues\Foundation\Domain\Model\Repository\Contracts\WriteRepository`


## InMemoryRepository Example

An example with a complete implementation can be found in the [/example directory](https://github.com/nilportugues/php-repository/tree/master/example).

In the example:

- Colors are defined as a class implementing the `Identity` interface.
- A `ColorRepository` is implemented. Will throw exception if Color is not found.
- Examples on how to filter are provided in the `example.php` file.

## Foundation Classes

Interaction with the repository requires the usage of the following classes or classes implementing interfaces.

- **NilPortugues\Foundation\Domain\Model\Repository\Fields**
    - `public function __construct(array $fields = [])`
    - `public function add($field)`
    - `public function get()`

- **NilPortugues\Foundation\Domain\Model\Repository\Filter**
    - `public function filters()`
    - `public function must()`
    - `public function mustNot()`
    - `public function should()`
    - `public function clear()`
    
- **NilPortugues\Foundation\Domain\Model\Repository\BaseFilter**   
    - `public function notStartsWith($filterName, $value)`
    - `public function notEndsWith($filterName, $value)`
    - `public function notEmpty($filterName)`
    - `public function empty($filterName)`
    - `public function startsWith($filterName, $value)`
    - `public function endsWith($filterName, $value)`
    - `public function equal($filterName, $value)`
    - `public function notEqual($filterName, $value)`
    - `public function includeGroup($filterName, array $value)`
    - `public function notIncludeGroup($filterName, array $value)`
    - `public function range($filterName, $firstValue, $secondValue)`
    - `public function notRange($filterName, $firstValue, $secondValue)`
    - `public function notContain($filterName, $value)`
    - `public function contain($filterName, $value)`
    - `public function beGreaterThanOrEqual($filterName, $value)`
    - `public function beGreaterThan($filterName, $value)`
    - `public function beLessThanOrEqual($filterName, $value)`
    - `public function beLessThan($filterName, $value)`
    - `public function clear()`
    - `public function get()`
    - `public function hasEmpty($filterName)` //alias of empty() for BC reasons.

- **NilPortugues\Foundation\Domain\Model\Repository\Order**
    - `public function __construct($direction)`
    - `public function isDescending()`
    - `public function isAscending()`
    - `public function __toString()`
    - `public function equals($object)`
    - `public function direction()`

- **NilPortugues\Foundation\Domain\Model\Repository\Pageable**
    - `public function __construct($pageNumber, $pageSize, SortInterface $sort = null, FilterInterface $filter = null, FieldsInterface $fields = null)`
    - `public function offset()`
    - `public function pageNumber()`
    - `public function sortings()`
    - `public function next()`
    - `public function pageSize()`
    - `public function previousOrFirst()`
    - `public function hasPrevious()`
    - `public function first()`
    - `public function filters()`
    - `public function fields()`

- **NilPortugues\Foundation\Domain\Model\Repository\Page**
    - `public function __construct(array $elements, $totalElements, $pageNumber, $totalPages, SortInterface $sort = null, FilterInterface $filter = null, FieldsInterface $fields = null)`
    - `public function content()`
    - `public function hasPrevious()`
    - `public function isFirst()`
    - `public function isLast()`
    - `public function hasNext()`
    - `public function pageSize()`
    - `public function pageNumber()`
    - `public function totalPages()`
    - `public function nextPageable()`
    - `public function sortings()`
    - `public function filters()`
    - `public function fields()`
    - `public function previousPageable()`
    - `public function totalElements()`
    - `public function map(callable $converter)`

- **NilPortugues\Foundation\Domain\Model\Repository\Sort**
    - `public function __construct(array $properties = [], OrderInterface $order = null)`
    - `public function andSort(SortInterface $sort)`
    - `public function orders()`
    - `public function equals(SortInterface $sort)`
    - `public function orderFor($propertyName)`
    - `public function setOrderFor($propertyName, OrderInterface $order)`
    - `public function property($propertyName)`

#### Interfaces 

- **NilPortugues\Foundation\Domain\Model\Repository\Contracts\Identity**

    - `public function id()`
    - `public function __toString()`
    
- **NilPortugues\Foundation\Domain\Model\Repository\Contracts\Repository**

    - `public function count(Filter $filter = null)`
    - `public function exists(Identity $id)`

- **NilPortugues\Foundation\Domain\Model\Repository\Contracts\PageRepository**

    - `public function findAll(Pageable $pageable = null)`

- **NilPortugues\Foundation\Domain\Model\Repository\Contracts\ReadRepository**

    - `public function find(Identity $id, Fields $fields = null)`
    - `public function findBy(Filter $filter = null, Sort $sort = null, Fields $fields = null)`
    - `public function findByDistinct(Fields $distinctFields, Filter $filter = null, Sort $sort = null, Fields $fields = null)`

- **NilPortugues\Foundation\Domain\Model\Repository\Contracts\WriteRepository**

    - `public function add($value)`
    - `public function addAll(array $values)`
    - `public function remove(Identity $id)`
    - `public function removeAll(Filter $filter = null)`
    - `public function transactional(callable $transaction)`

---



## Quality

To run the PHPUnit tests at the command line, go to the tests directory and issue phpunit.

This library attempts to comply with [PSR-1](http://www.php-fig.org/psr/psr-1/), [PSR-2](http://www.php-fig.org/psr/psr-2/), [PSR-4](http://www.php-fig.org/psr/psr-4/).

If you notice compliance oversights, please send a patch via [Pull Request](https://github.com/nilportugues/repository/pulls).


## Contribute

Contributions to the package are always welcome!

* Report any bugs or issues you find on the [issue tracker](https://github.com/nilportugues/repository/issues/new).
* You can grab the source code at the package's [Git repository](https://github.com/nilportugues/repository).


## Support

Get in touch with me using one of the following means:

 - Emailing me at <contact@nilportugues.com>
 - Opening an [Issue](https://github.com/nilportugues/repository/issues/new)


## Authors

* [Nil Portugués Calderó](http://nilportugues.com)
* [The Community Contributors](https://github.com/nilportugues/repository/graphs/contributors)


## License
The code base is licensed under the [MIT license](LICENSE).
