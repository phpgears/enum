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
    protected static $enumCacheMap = [];

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
        $this->assertImmutable();

        $this->checkValue($value);

        $this->value = $value;
    }

    /**
     * Value based static constructor.
     *
     * @param string  $value
     * @param mixed[] $params
     *
     * @return self
     */
    final public static function __callStatic(string $value, array $params)
    {
        if (\count($params) !== 0) {
            throw new InvalidEnumValueException('Enum static constructor must be called with no parameters');
        }

        $validValues = static::getValidValues();

        if (!\array_key_exists($value, $validValues)) {
            throw new InvalidEnumValueException(\sprintf(
                '"%s" is not a valid value for enum "%s"',
                $value,
                static::class
            ));
        }

        return new static($validValues[$value]);
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
    final public function isAnyOf(array $enums): bool
    {
        foreach ($enums as $enum) {
            if ($this->isEqualTo($enum)) {
                return true;
            }
        }

        return false;
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
                '"%s" is not a valid value for enum "%s"',
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
        $enumClass = static::class;

        if (!isset(static::$enumCacheMap[$enumClass])) {
            static::$enumCacheMap[$enumClass] = (new \ReflectionClass($enumClass))->getConstants();
        }

        return static::$enumCacheMap[$enumClass];
    }

    /**
     * {@inheritdoc}
     *
     * @return string[]
     */
    final protected function getAllowedInterfaces(): array
    {
        return [Enum::class];
    }
}
