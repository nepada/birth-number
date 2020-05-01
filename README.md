Czech birth number value object
===============================

[![Build Status](https://travis-ci.org/nepada/birth-number.svg?branch=master)](https://travis-ci.org/nepada/birth-number)
[![Coverage Status](https://coveralls.io/repos/github/nepada/birth-number/badge.svg?branch=master)](https://coveralls.io/github/nepada/birth-number?branch=master)
[![Downloads this Month](https://img.shields.io/packagist/dm/nepada/birth-number.svg)](https://packagist.org/packages/nepada/birth-number)
[![Latest stable](https://img.shields.io/packagist/v/nepada/birth-number.svg)](https://packagist.org/packages/nepada/birth-number)


Installation
------------

Via Composer:

```sh
$ composer require nepada/birth-number
```


Usage
-----

#### Creating value object

The parser is quite benevolent with regard to the delimiter separating the ending of birth number.
```php
$birthNumber = Nepada\BirthNumber\BirthNumber::fromString('0421010030');
$birthNumber = Nepada\BirthNumber\BirthNumber::fromString('042101/0030');
$birthNumber = Nepada\BirthNumber\BirthNumber::fromString('042101 0030');
$birthNumber = Nepada\BirthNumber\BirthNumber::fromString('042101 / 0030');
```
`Nepada\BirthNumber\InvalidBirthNumberException` is thrown in case of invalid input value.

#### Converting back to string
```php
echo((string) $birthNumber); // '042101/0030'
echo($birthNumber->toString()); // '042101/0030'
echo($birthNumber->toStringWithoutSlash()); // '0421010030'
```

#### Validation
```php
Nepada\BirthNumber\BirthNumber::isValid('0421010030'); // true
Nepada\BirthNumber\BirthNumber::isValid('9999999999'); // false
```

#### Comparison
```php
$birthNumber1 = Nepada\BirthNumber\BirthNumber::fromString('042101/0030');
$birthNumber2 = Nepada\BirthNumber\BirthNumber::fromString('042101/0030');
$birthNumber1->equals($birthNumber2); // true
```

#### Extracting information from birth number
```php
$birthNumber = Nepada\BirthNumber\BirthNumber::fromString('047101 / 0090');
$birthNumber->getBirthDate(); // \DateTimeImmutable('2004-01-01')

$gender = $birthNumber->getGender(); // Nepada\BirthNumber\Gender enum instance
$gender->isFemale(); // true
$gender->isMale(); // false
$gender->toString(); // 'female'
```


Integrations
------------

- [nepada/birth-number-doctrine](https://github.com/nepada/birth-number-doctrine) - Birth number type for Doctrine.
- [nepada/birth-number-input](https://github.com/nepada/birth-number-input) - Birth number form input for Nette forms.
