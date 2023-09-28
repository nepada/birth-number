<?php
declare(strict_types = 1);

namespace NepadaTests\BirthNumber;

use Nepada\BirthNumber\Gender;
use NepadaTests\TestCase;
use Tester\Assert;

require_once __DIR__ . '/../bootstrap.php';


/**
 * @testCase
 */
class GenderTest extends TestCase
{

    public function testMale(): void
    {
        $gender = Gender::fromString(Gender::MALE);

        Assert::same(Gender::MALE, $gender->toString());

        Assert::true($gender->isMale());
        Assert::true($gender->equals(Gender::male()));

        Assert::false($gender->isFemale());
        Assert::false($gender->equals(Gender::female()));
    }

    public function testFemale(): void
    {
        $gender = Gender::fromString(Gender::FEMALE);

        Assert::same(Gender::FEMALE, $gender->toString());

        Assert::false($gender->isMale());
        Assert::false($gender->equals(Gender::male()));

        Assert::true($gender->isFemale());
        Assert::true($gender->equals(Gender::female()));
    }

    public function testInvalid(): void
    {
        Assert::exception(
            function (): void {
                Gender::fromString('invalid');
            },
            \ValueError::class,
            '"invalid" is not a valid backing value for enum %a%',
        );
    }

}


(new GenderTest())->run();
