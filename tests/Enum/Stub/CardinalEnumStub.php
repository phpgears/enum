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
 * Cardinal enum stub class.
 *
 * @method static self VALUE_FIRST()
 * @method static self VALUE_SECOND()
 * @method static self VALUE_THIRD()
 */
final class CardinalEnumStub extends AbstractEnum
{
    public const VALUE_FIRST = 'first';

    public const VALUE_SECOND = 'second';

    public const VALUE_THIRD = 'third';
}
