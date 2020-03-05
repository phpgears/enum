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
 * Ordinal enum stub class.
 *
 * @method static self VALUE_ONE()
 * @method static self VALUE_TWO()
 * @method static self VALUE_THREE()
 */
final class OrdinalEnumStub extends AbstractEnum
{
    public const VALUE_ONE = 'one';

    public const VALUE_TWO = 'two';

    public const VALUE_THREE = 'three';
}
