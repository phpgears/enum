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

namespace Gears\Enum;

/**
 * Enum interface.
 */
interface Enum
{
    /**
     * Check enum equality.
     *
     * @param self $enum
     *
     * @return bool
     */
    public function isEqualTo(self $enum): bool;

    /**
     * Get enum value.
     *
     * @return mixed
     */
    public function getValue();
}
