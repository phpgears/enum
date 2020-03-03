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

use Gears\Enum\Exception\EnumException;
use Gears\Enum\Exception\InvalidEnumNameException;
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
     * @param string  $name
     * @param mixed[] $params
     *
     * @return self
     */
    final public static function __callStatic(string $name, array $params)
    {
        if (\count($params) !== 0) {
            throw new EnumException('Enum static constructor must be called with no parameters');
        }

        $enumerator = static::normalizeName($name);
        $enumerators = static::getEnumerators();

        if (!\array_key_exists($enumerator, $enumerators)) {
            throw new InvalidEnumNameException(\sprintf(
                '"%s" is not a valid enumerator for enum "%s"',
                $name,
                static::class
            ));
        }

        return new static($enumerators[$enumerator]);
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
     * @return mixed[]
     */
    final public function __sleep(): array
    {
        throw new EnumException(\sprintf('Enum "%s" cannot be serialized', static::class));
    }

    final public function __wakeup(): void
    {
        throw new EnumException(\sprintf('Enum "%s" cannot be unserialized', static::class));
    }

    /**
     * @return mixed[]
     *
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    final public function __serialize(): array
    {
        throw new EnumException(\sprintf('Enum "%s" cannot be serialized', static::class));
    }

    /**
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    final public function __unserialize(): void
    {
        throw new EnumException(\sprintf('Enum "%s" cannot be unserialized', static::class));
    }

    final public function __clone()
    {
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
        if (!\in_array($value, static::getEnumerators(), true)) {
            throw new InvalidEnumValueException(\sprintf(
                '"%s" is not a valid value for enum "%s"',
                $value,
                static::class
            ));
        }
    }

    /**
     * Get list of enumerators.
     *
     * @return array<string, mixed>
     */
    private static function getEnumerators(): array
    {
        $class = static::class;

        if (!isset(static::$enumCacheMap[$class])) {
            $constants = [];
            foreach ((new \ReflectionClass($class))->getReflectionConstants() as $reflectionConstant) {
                if ($reflectionConstant->isPublic()) {
                    $constants[static::normalizeName($reflectionConstant->getName())] = $reflectionConstant->getValue();
                }
            }

            static::$enumCacheMap[$class] = $constants;
        }

        return static::$enumCacheMap[$class];
    }

    /**
     * Normalize name.
     *
     * @param string $name
     *
     * @return string
     */
    private static function normalizeName(string $name): string
    {
        return \strtoupper($name);
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
