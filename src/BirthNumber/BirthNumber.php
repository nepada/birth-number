<?php
declare(strict_types = 1);

namespace Nepada\BirthNumber;

use Nette;
use Nette\Utils\Strings;

final class BirthNumber
{

    use Nette\SmartObject;

    private int $year;

    private int $month;

    private int $day;

    private int $baseYear;

    private int $monthModifier;

    private string $ending;

    private function __construct(int $year, int $month, int $day, int $baseYear, int $monthModifier, string $ending)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->baseYear = $baseYear;
        $this->monthModifier = $monthModifier;
        $this->ending = $ending;
    }

    /**
     * @throws InvalidBirthNumberException
     */
    public static function fromString(string $value): self
    {
        $match = Strings::match($value, '~^\s*(\d\d)(\d\d)(\d\d)\s*/?\s*(\d\d\d)(\d?)\s*$~');
        if ($match === null) {
            throw InvalidBirthNumberException::withValue($value);
        }

        [, $yearPart, $monthPart, $dayPart, $extension, $checksum] = $match;

        $year = (int) $yearPart;
        $month = (int) $monthPart;
        $day = (int) $dayPart;

        $baseYear = 1_900;
        if ($year < 54) {
            if ($checksum !== '') {
                $baseYear = 2_000;
            }
        } elseif ($checksum === '') {
            throw InvalidBirthNumberException::withValue($value);
        }
        $year += $baseYear;

        if ($checksum !== '') {
            $mod = (((int) ($yearPart . $monthPart . $dayPart . $extension)) % 11) % 10;
            if ($mod !== (int) $checksum) {
                throw InvalidBirthNumberException::withValue($value);
            }
        }

        $monthModifier = 0;
        if ($month > 50) {
            $monthModifier += 50;
            $month -= 50;
        }
        if ($month > 20 && $year > 2_003) {
            $monthModifier += 20;
            $month -= 20;
        }

        if (! checkdate($month, $day, $year)) {
            throw InvalidBirthNumberException::withValue($value);
        }

        $ending = $extension . $checksum;

        return new self($year, $month, $day, $baseYear, $monthModifier, $ending);
    }

    public static function isValid(string $value): bool
    {
        try {
            self::fromString($value);
            return true;

        } catch (InvalidBirthNumberException $exception) {
            return false;
        }
    }

    public function getBirthDate(): \DateTimeImmutable
    {
        return new \DateTimeImmutable(sprintf('%d-%02d-%02d', $this->year, $this->month, $this->day));
    }

    public function getGender(): Gender
    {
        return $this->monthModifier >= 50 ? Gender::Female : Gender::Male;
    }

    public function toString(): string
    {
        return sprintf('%02d%02d%02d/%s', $this->year - $this->baseYear, $this->month + $this->monthModifier, $this->day, $this->ending);
    }

    public function toStringWithoutSlash(): string
    {
        return str_replace('/', '', $this->toString());
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function equals(self $other): bool
    {
        return $this->toString() === $other->toString();
    }

}
