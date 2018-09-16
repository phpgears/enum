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

use Gears\Enum\Exception\InvalidEnumValueException;
use Gears\Immutability\ImmutabilityBehaviour;

/**
 * Base immutable enum class.
 */
abstract class AbstractEnum implements Enum
{
    use ImmutabilityBehaviour;

    /**
     * Enum class constants map.
     *
     * @var array
     */
    protected static $enumConstantsMap = [];

    /**
     * Enum value.
     *
     * @var mixed
     */
    private $value;

    /**
     * AbstractEnum constructor.
     *
     * @param mixed $value
     *
     * @throws InvalidEnumValueException
     */
    final public function __construct($value)
    {
        $this->checkImmutability();

        $this->checkValue($value);

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    final public function isEqualTo(Enum $enum): bool
    {
        return \get_class($enum) === static::class && $enum->getValue() === $this->value;
    }

    /**
     * {@inheritdoc}
     */
    final public function getValue()
    {
        return $this->value;
    }

    /**
     * Check enum value validity.
     *
     * @param mixed $value
     *
     * @throws InvalidEnumValueException
     */
    private function checkValue($value): void
    {
        if (!\in_array($value, static::getValidValues(), true)) {
            throw new InvalidEnumValueException(\sprintf(
                '%s is not a valid value for enum %s',
                $value,
                static::class
            ));
        }
    }

    /**
     * Get list of valid enum values.
     *
     * @return array<string, mixed>
     */
    private static function getValidValues(): array
    {
        $class = static::class;

        if (!isset(static::$enumConstantsMap[$class])) {
            static::$enumConstantsMap[$class] = (new \ReflectionClass($class))->getConstants();
        }

        return static::$enumConstantsMap[$class];
    }

    /**
     * {@inheritdoc}
     *
     * @return string[]
     */
    final protected function getAllowedInterfaces(): array
    {
        return [Enum::class, self::class];
    }
}
