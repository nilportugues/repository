# Repository

[![Build Status](https://travis-ci.org/nilportugues/repository.svg)](https://travis-ci.org/nilportugues/repository) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nilportugues/repository/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nilportugues/repository/?branch=master) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/428e1f96-bcf4-4dee-866e-7a7cb5db52e4/mini.png)](https://insight.sensiolabs.com/projects/428e1f96-bcf4-4dee-866e-7a7cb5db52e4) [![Latest Stable Version](https://poser.pugx.org/nilportugues/repository/v/stable)](https://packagist.org/packages/nilportugues/repository) [![Total Downloads](https://poser.pugx.org/nilportugues/repository/downloads)](https://packagist.org/packages/nilportugues/repository) [![License](https://poser.pugx.org/nilportugues/repository/license)](https://packagist.org/packages/nilportugues/repository)

Generic implementation and definition of a Repository and its in-memory implementation.

# Building blocks

Interaction with the repository requires the usage of the following classes or classes implementing interfaces.

**Classes**

- `NilPortugues\Foundation\Domain\Model\Repository\Fields`
- `NilPortugues\Foundation\Domain\Model\Repository\Filter`
- `NilPortugues\Foundation\Domain\Model\Repository\Order`
- `NilPortugues\Foundation\Domain\Model\Repository\Pageable`
- `NilPortugues\Foundation\Domain\Model\Repository\Page`
- `NilPortugues\Foundation\Domain\Model\Repository\Sort`

**Interfaces** 

- `NilPortugues\Foundation\Domain\Model\Repository\Contracts\Identity`
- `NilPortugues\Foundation\Domain\Model\Repository\Contracts\Repository`
- `NilPortugues\Foundation\Domain\Model\Repository\Contracts\PageRepository`
- `NilPortugues\Foundation\Domain\Model\Repository\Contracts\ReadRepository`
- `NilPortugues\Foundation\Domain\Model\Repository\Contracts\WriteRepository`

# InMemory Implementation

WIP

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
