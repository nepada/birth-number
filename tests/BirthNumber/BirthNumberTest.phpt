<?php
declare(strict_types = 1);

namespace NepadaTests\BirthNumber;

use Nepada\BirthNumber\BirthNumber;
use Nepada\BirthNumber\Gender;
use Nepada\BirthNumber\InvalidBirthNumberException;
use NepadaTests\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


/**
 * @testCase
 */
class BirthNumberTest extends TestCase
{

    /**
     * @dataProvider getValid
     */
    public function testValid(string $value, \DateTimeImmutable $birthDate, Gender $gender, string $asString, string $asStringWithoutSlash): void
    {
        Assert::true(BirthNumber::isValid($value));

        $birthNumber = BirthNumber::fromString($value);

        Assert::equal($birthDate, $birthNumber->getBirthDate());
        Assert::same((string) $gender, (string) $birthNumber->getGender());

        Assert::same($asString, (string) $birthNumber);
        Assert::same($asString, $birthNumber->toString());

        Assert::same($asStringWithoutSlash, $birthNumber->toStringWithoutSlash());

        Assert::true($birthNumber->equals(BirthNumber::fromString($asString)));
        Assert::true($birthNumber->equals(BirthNumber::fromString($asStringWithoutSlash)));
        Assert::false($birthNumber->equals(BirthNumber::fromString('0001010009')));
    }

    /**
     * @return mixed[]
     */
    protected function getValid(): array
    {
        return [
            [
                'value' => '531231123',
                'birthDate' => new \DateTimeImmutable('1953-12-31'),
                'gender' => Gender::male(),
                'asString' => '531231/123',
                'asStringWithoutSlash' => '531231123',
            ],
            [
                'value' => '5312311235',
                'birthDate' => new \DateTimeImmutable('2053-12-31'),
                'gender' => Gender::male(),
                'asString' => '531231/1235',
                'asStringWithoutSlash' => '5312311235',
            ],
            [
                'value' => "900101 \t 0007",
                'birthDate' => new \DateTimeImmutable('1990-01-01'),
                'gender' => Gender::male(),
                'asString' => '900101/0007',
                'asStringWithoutSlash' => '9001010007',
            ],
            [
                'value' => '905101 / 0001',
                'birthDate' => new \DateTimeImmutable('1990-01-01'),
                'gender' => Gender::female(),
                'asString' => '905101/0001',
                'asStringWithoutSlash' => '9051010001',
            ],
            [
                'value' => "042101 \t 0030",
                'birthDate' => new \DateTimeImmutable('2004-01-01'),
                'gender' => Gender::male(),
                'asString' => '042101/0030',
                'asStringWithoutSlash' => '0421010030',
            ],
            [
                'value' => '047101 / 0090',
                'birthDate' => new \DateTimeImmutable('2004-01-01'),
                'gender' => Gender::female(),
                'asString' => '047101/0090',
                'asStringWithoutSlash' => '0471010090',
            ],
        ];
    }

    /**
     * @dataProvider getInvalid
     */
    public function testInvalid(string $description, string $value): void
    {
        Assert::false(BirthNumber::isValid($value), $description);
        Assert::exception(
            function () use ($value): void {
                BirthNumber::fromString($value);
            },
            InvalidBirthNumberException::class,
        );
    }

    /**
     * @return mixed[]
     */
    protected function getInvalid(): array
    {
        return [
            [
                'description' => 'Empty',
                'value' => '',
            ],
            [
                'description' => 'Garbage',
                'value' => 'Lorem ipsum',
            ],
            [
                'description' => 'Invalid date',
                'value' => '000230 / 0001',
            ],
            [
                'description' => '+20 month modifier used before 2004',
                'value' => '032101 / 0008',
            ],
            [
                'description' => '+70 month modifier used before 2004',
                'value' => '037101 / 0002',
            ],
            [
                'description' => 'Missing checksum',
                'value' => '540101 / 000',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0000',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0001',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0002',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0003',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0004',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0005',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0006',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0007',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0008',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0011',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0012',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0013',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0014',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0015',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0016',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0017',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0018',
            ],
            [
                'description' => 'Invalid checksum',
                'value' => '000101 / 0019',
            ],
        ];
    }

}


(new BirthNumberTest())->run();
