<?php
declare(strict_types = 1);

namespace Nepada\BirthNumber;

class InvalidBirthNumberException extends \InvalidArgumentException
{

    public static function withValue(string $value): InvalidBirthNumberException
    {
        return new InvalidBirthNumberException("Invalid birth number: '$value'");
    }

}
