<?php

declare(strict_types=1);

namespace NorseBlue\ValueObjects\SingleProperty;

use NorseBlue\ValueObjects\Exceptions\InvalidValueException;
use NorseBlue\ValueObjects\ValueObject;

abstract class SinglePropertyValueObject extends ValueObject
{
    /** @var mixed The objects's value */
    protected $value;

    /**
     * Create a new instance.
     *
     * @param mixed $value
     */
    final public function __construct($value = null)
    {
        $this->changeValueProperty($value);
    }

    /**
     * Unwrap the value object.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    final public static function unwrap($value)
    {
        if ($value instanceof self) {
            $value = $value->value;
        }

        return $value;
    }

    /**
     * Check if the value objects equals another value.
     *
     * @param mixed $other
     *
     * @return bool
     */
    final public function equals($other): bool
    {
        return $this->value === self::unwrap($other);
    }

    /**
     * Value accessor.
     *
     * @return mixed
     */
    final public function getValueProperty()
    {
        return $this->value;
    }

    /**
     * Value mutator.
     *
     * @param mixed $value
     */
    final public function changeValueProperty($value): void
    {
        if (!$value instanceof static && !$this->isValid($value)) {
            throw new InvalidValueException('The given value is not valid.');
        }

        $this->value = static::unwrap($value);
    }

    /**
     * Converts the object to string by casting the value.
     *
     * @return string
     */
    final public function __toString(): string
    {
        return (string)$this->value;
    }
}
