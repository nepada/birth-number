<?php
declare(strict_types = 1);

namespace Nepada\BirthNumber;

enum Gender: string
{

    case Male = 'male';
    case Female = 'female';

    /** @deprecated use enum case value instead */
    final public const MALE = 'male';

    /** @deprecated use enum case value instead */
    final public const FEMALE = 'female';

    /**
     * @deprecated use enum case directly
     */
    public static function male(): self
    {
        return self::Male;
    }

    /**
     * @deprecated use enum case directly
     */
    public static function female(): self
    {
        return self::Female;
    }

    public static function fromString(string $value): self
    {
        return self::from($value);
    }

    public function isMale(): bool
    {
        return $this === self::Male;
    }

    public function isFemale(): bool
    {
        return $this === self::Female;
    }

    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @deprecated use direct enum case comparison instead
     */
    public function equals(self $other): bool
    {
        return $this === $other;
    }

}
