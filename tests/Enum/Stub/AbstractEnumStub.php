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
 * Abstract enum stub class.
 *
 * @method static self VALUE_ONE()
 * @method static self VALUE_TWO()
 */
class AbstractEnumStub extends AbstractEnum
{
    public const VALUE_ONE = 'one';

    public const VALUE_TWO = 'two';
}
