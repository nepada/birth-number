<?php
declare(strict_types = 1);

namespace Nepada\BirthNumber;

class InvalidBirthNumberException extends \InvalidArgumentException
{

    public static function withValue(string $value): self
    {
        return new self("Invalid birth number: '$value'");
    }

}
