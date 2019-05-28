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

use Gears\Enum\Tests\Stub\AbstractEnumStub;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractEnumTest.
 */
class AbstractEnumTest extends TestCase
{
    /**
     * @expectedException \Gears\Enum\Exception\InvalidEnumValueException
     * @expectedExceptionMessage unknown is not a valid value for enum Gears\Enum\Tests\Stub\AbstractEnumStub
     */
    public function testInvalidValue(): void
    {
        new AbstractEnumStub('unknown');
    }

    public function testCreation(): void
    {
        $stub = new AbstractEnumStub('one');

        $this->assertSame(AbstractEnumStub::VALUE_ONE, $stub->getValue());
        $this->assertTrue($stub->isEqualTo(new AbstractEnumStub(AbstractEnumStub::VALUE_ONE)));
        $this->assertFalse($stub->isEqualTo(new AbstractEnumStub(AbstractEnumStub::VALUE_TWO)));
        $this->assertTrue($stub->isAnyOf([
            new AbstractEnumStub(AbstractEnumStub::VALUE_TWO),
            new AbstractEnumStub(AbstractEnumStub::VALUE_ONE),
        ]));
        $this->assertFalse($stub->isAnyOf([
            new AbstractEnumStub(AbstractEnumStub::VALUE_TWO),
            new AbstractEnumStub(AbstractEnumStub::VALUE_THREE),
        ]));
    }

    /**
     * @expectedException \Gears\Enum\Exception\InvalidEnumValueException
     * @expectedExceptionMessage UNKNOWN is not a valid value for enum Gears\Enum\Tests\Stub\AbstractEnumStub
     */
    public function testInvalidStaticValue(): void
    {
        AbstractEnumStub::UNKNOWN();
    }

    /**
     * @expectedException \Gears\Enum\Exception\InvalidEnumValueException
     * @expectedExceptionMessage Enum static constructor must be called with no parameters
     */
    public function testInvalidStaticCreation(): void
    {
        AbstractEnumStub::VALUE_ONE('param');
    }

    public function testStaticCreation(): void
    {
        $stub = AbstractEnumStub::VALUE_ONE();

        $this->assertSame('one', $stub->getValue());
        $this->assertTrue($stub->isEqualTo(AbstractEnumStub::VALUE_ONE()));
        $this->assertFalse($stub->isEqualTo(AbstractEnumStub::VALUE_TWO()));
        $this->assertTrue($stub->isAnyOf([AbstractEnumStub::VALUE_TWO(), AbstractEnumStub::VALUE_ONE()]));
        $this->assertFalse($stub->isAnyOf([AbstractEnumStub::VALUE_TWO(), AbstractEnumStub::VALUE_THREE()]));
    }
}
