[![PHP version](https://img.shields.io/badge/PHP-%3E%3D7.1-8892BF.svg?style=flat-square)](http://php.net)
[![Latest Version](https://img.shields.io/packagist/v/phpgears/enum.svg?style=flat-square)](https://packagist.org/packages/phpgears/enum)
[![License](https://img.shields.io/github/license/phpgears/enum.svg?style=flat-square)](https://github.com/phpgears/enum/blob/master/LICENSE)

[![Build Status](https://img.shields.io/travis/phpgears/enum.svg?style=flat-square)](https://travis-ci.org/phpgears/enum)
[![Style Check](https://styleci.io/repos/148840983/shield)](https://styleci.io/repos/148840983)
[![Code Quality](https://img.shields.io/scrutinizer/g/phpgears/enum.svg?style=flat-square)](https://scrutinizer-ci.com/g/phpgears/enum)
[![Code Coverage](https://img.shields.io/coveralls/phpgears/enum.svg?style=flat-square)](https://coveralls.io/github/phpgears/enum)

[![Total Downloads](https://img.shields.io/packagist/dt/phpgears/enum.svg?style=flat-square)](https://packagist.org/packages/phpgears/enum/stats)
[![Monthly Downloads](https://img.shields.io/packagist/dm/phpgears/enum.svg?style=flat-square)](https://packagist.org/packages/phpgears/enum/stats)

# Enum

Immutable Enum objects for PHP

Other languages have the concept of Enum and while there is an extension in PHP for enums it's not available by default or widely spread

The implementation of an Enum class is not so difficult, but it should cover value validation and be immutable so its value cannot be changed

## Installation

### Composer

```
composer require phpgears/enum
```

## Usage

Require composer autoload file

```php
require './vendor/autoload.php';
```

By extending `Gears\Enum\AbstractEnum` you can easily have Enum classes

```php
use Gears\Enum\AbstractEnum;

/**
 * @method static self DAILY()
 * @method static self WEEKLY()
 * @method static self BIWEEKLY()
 * @method static self MONTHLY()
 * @method static self YEARLY()
 */
class DatePeriod extends AbstractEnum
{
    public const DAILY = 'daily';
    public const WEEKLY = 'weekly';
    public const BIWEEKLY = 'biweekly';
    public const MONTHLY = 'monthly';
    public const YEARLY = 'yearly';
}

$period = new DatePeriod('daily');

$period->getValue() === DatePeriod::DAILY; // true
$period->isEqualTo(DatePeriod::DAILY()); // true
$period->isAnyOf([DatePeriod::DAILY(), DatePeriod::WEEKLY()]); // true

$period->getValue() === DatePeriod::YEARLY; // false
$period->isEqualTo(DatePeriod::MONTHLY()); // false
$period->isAnyOf([DatePeriod::MONTHLY(), DatePeriod::YEARLY()]); // false

$period->getValue(); // daily


$newPeriod = new DatePeriod($period);

$newPeriod->getValue() === DatePeriod::DAILY; // true
$newPeriod->getValue() === $period->getValue(); // true
$newPeriod->isEqualTo($period); // true

$newPeriod->getValue(); // daily
```

_It is advised to add `@method` annotation references on class docblock for your editor to be able to help you with auto-completion_ 

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/phpgears/enum/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/phpgears/enum/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/phpgears/enum/blob/master/LICENSE) included with the source code for a copy of the license terms.
