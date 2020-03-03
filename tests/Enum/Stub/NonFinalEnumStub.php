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

namespace Gears\Enum\Tests\Stub;

use Gears\Enum\AbstractEnum;

/**
 * Non final enum stub class.
 *
 * @method static self VALUE_ZERO()
 */
class NonFinalEnumStub extends AbstractEnum
{
    public const VALUE_ZERO = 0;
}
