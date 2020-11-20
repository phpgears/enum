<?php

/*
 * enum (https://github.com/phpgears/enum).
 * Enum object for PHP.
 *
 * @license MIT
 * @link https://github.com/phpgears/enum
 * @author Julián Gutiérrez <juliangut@gmail.com>
 */

declare(strict_types=1);

namespace Gears\Enum\Tests;

use Gears\Enum\Exception\EnumException;
use Gears\Enum\Exception\InvalidEnumNameException;
use Gears\Enum\Exception\InvalidEnumValueException;
use Gears\Enum\Tests\Stub\CardinalEnumStub;
use Gears\Enum\Tests\Stub\NonFinalEnumStub;
use Gears\Enum\Tests\Stub\OrdinalEnumStub;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractEnumTest.
 */
class AbstractEnumTest extends TestCase
{
    public function testNonFinal(): void
    {
        $this->expectException(EnumException::class);
        $this->expectExceptionMessage('Enum class "Gears\Enum\Tests\Stub\NonFinalEnumStub" should be final.');

        NonFinalEnumStub::VALUE_ZERO();
    }

    public function testInvalidFromEnum(): void
    {
        $this->expectException(InvalidEnumValueException::class);
        $this->expectExceptionMessageRegExp(
            '/^Enum ".+\\OrdinalEnumStub" cannot be created from enum ".+\\CardinalEnumStub"\.$/'
        );

        new OrdinalEnumStub(CardinalEnumStub::VALUE_FIRST());
    }

    public function testInvalidValue(): void
    {
        $this->expectException(InvalidEnumValueException::class);
        $this->expectExceptionMessage(
            '"unknown" is not a valid value for enum "Gears\Enum\Tests\Stub\CardinalEnumStub".'
        );

        new CardinalEnumStub('unknown');
    }

    /**
     * @dataProvider creationDataProvider
     *
     * @param mixed $enumValue
     */
    public function testCreation($enumValue): void
    {
        $stub = new OrdinalEnumStub($enumValue);

        static::assertSame(OrdinalEnumStub::VALUE_ONE, $stub->getValue());
        static::assertTrue($stub->isEqualTo(new OrdinalEnumStub(OrdinalEnumStub::VALUE_ONE)));
        static::assertFalse($stub->isEqualTo(OrdinalEnumStub::VALUE_TWO()));
        static::assertTrue($stub->isAnyOf([
            new OrdinalEnumStub(OrdinalEnumStub::VALUE_TWO),
            new OrdinalEnumStub(OrdinalEnumStub::VALUE_ONE),
        ]));
        static::assertFalse($stub->isAnyOf([
            new OrdinalEnumStub(OrdinalEnumStub::VALUE_TWO),
            new OrdinalEnumStub(OrdinalEnumStub::VALUE_THREE),
        ]));
    }

    /**
     * @return array<mixed[]>
     */
    public function creationDataProvider(): array
    {
        return [
            [OrdinalEnumStub::VALUE_ONE()],
            [OrdinalEnumStub::VALUE_ONE],
        ];
    }

    public function testInvalidStaticValue(): void
    {
        $this->expectException(InvalidEnumNameException::class);
        $this->expectExceptionMessage(
            '"UNKNOWN" is not a valid enumerator for enum "Gears\Enum\Tests\Stub\CardinalEnumStub".'
        );

        CardinalEnumStub::UNKNOWN();
    }

    public function testInvalidStaticCreation(): void
    {
        $this->expectException(EnumException::class);
        $this->expectExceptionMessage('Enum static constructor must be called with no parameters.');

        OrdinalEnumStub::VALUE_ONE('param');
    }

    public function testStaticCreation(): void
    {
        $stub = OrdinalEnumStub::Value_One();

        static::assertSame('one', $stub->getValue());
        static::assertTrue($stub->isEqualTo(OrdinalEnumStub::VALUE_ONE()));
        static::assertFalse($stub->isEqualTo(OrdinalEnumStub::VALUE_TWO()));
        static::assertTrue($stub->isAnyOf([OrdinalEnumStub::VALUE_TWO(), OrdinalEnumStub::VALUE_ONE()]));
        static::assertFalse($stub->isAnyOf([OrdinalEnumStub::VALUE_TWO(), OrdinalEnumStub::VALUE_THREE()]));
    }

    public function testSerialization(): void
    {
        $stub = OrdinalEnumStub::VALUE_ONE();

        $serialized = \version_compare(\PHP_VERSION, '7.4.0') >= 0
            ? 'O:37:"Gears\Enum\Tests\Stub\OrdinalEnumStub":1:{s:5:"value";s:3:"one";}'
            : 'C:37:"Gears\Enum\Tests\Stub\OrdinalEnumStub":10:{s:3:"one";}';

        static::assertSame($serialized, \serialize($stub));
        static::assertSame('one', (\unserialize($serialized))->getValue());
    }

    public function testClone(): void
    {
        $original = OrdinalEnumStub::VALUE_TWO();
        $clone = clone $original;

        static::assertTrue($original !== $clone);
        static::assertTrue($original->isEqualTo($clone));
    }
}
