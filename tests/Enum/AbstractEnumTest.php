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
use Gears\Enum\Tests\Stub\AbstractEnumStub;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractEnumTest.
 */
class AbstractEnumTest extends TestCase
{
    public function testInvalidValue(): void
    {
        $this->expectException(InvalidEnumValueException::class);
        $this->expectExceptionMessage(
            '"unknown" is not a valid value for enum "Gears\Enum\Tests\Stub\AbstractEnumStub"'
        );

        new AbstractEnumStub('unknown');
    }

    public function testCreation(): void
    {
        $stub = new AbstractEnumStub('one');

        static::assertSame(AbstractEnumStub::VALUE_ONE, $stub->getValue());
        static::assertTrue($stub->isEqualTo(new AbstractEnumStub(AbstractEnumStub::VALUE_ONE)));
        static::assertFalse($stub->isEqualTo(new AbstractEnumStub(AbstractEnumStub::VALUE_TWO)));
        static::assertTrue($stub->isAnyOf([
            new AbstractEnumStub(AbstractEnumStub::VALUE_TWO),
            new AbstractEnumStub(AbstractEnumStub::VALUE_ONE),
        ]));
        static::assertFalse($stub->isAnyOf([
            new AbstractEnumStub(AbstractEnumStub::VALUE_TWO),
            new AbstractEnumStub(AbstractEnumStub::VALUE_THREE),
        ]));
    }

    public function testInvalidStaticValue(): void
    {
        $this->expectException(InvalidEnumNameException::class);
        $this->expectExceptionMessage(
            '"UNKNOWN" is not a valid enumerator for enum "Gears\Enum\Tests\Stub\AbstractEnumStub"'
        );

        AbstractEnumStub::UNKNOWN();
    }

    public function testInvalidStaticCreation(): void
    {
        $this->expectException(EnumException::class);
        $this->expectExceptionMessage('Enum static constructor must be called with no parameters');

        AbstractEnumStub::VALUE_ONE('param');
    }

    public function testStaticCreation(): void
    {
        $stub = AbstractEnumStub::Value_One();

        static::assertSame('one', $stub->getValue());
        static::assertTrue($stub->isEqualTo(AbstractEnumStub::VALUE_ONE()));
        static::assertFalse($stub->isEqualTo(AbstractEnumStub::VALUE_TWO()));
        static::assertTrue($stub->isAnyOf([AbstractEnumStub::VALUE_TWO(), AbstractEnumStub::VALUE_ONE()]));
        static::assertFalse($stub->isAnyOf([AbstractEnumStub::VALUE_TWO(), AbstractEnumStub::VALUE_THREE()]));
    }
}
