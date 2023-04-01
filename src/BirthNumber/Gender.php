<?php
declare(strict_types = 1);

namespace Nepada\BirthNumber;

use Nette;

final class Gender
{

    use Nette\SmartObject;

    public const MALE = 'male';
    public const FEMALE = 'female';

    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function male(): self
    {
        return new self(self::MALE);
    }

    public static function female(): self
    {
        return new self(self::FEMALE);
    }

    public static function fromString(string $value): self
    {
        if ($value === self::MALE) {
            return self::male();
        }

        if ($value === self::FEMALE) {
            return self::female();
        }

        throw new \InvalidArgumentException("Invalid gender value '$value'.");
    }

    public function isMale(): bool
    {
        return $this->value === self::MALE;
    }

    public function isFemale(): bool
    {
        return $this->value === self::FEMALE;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

}
