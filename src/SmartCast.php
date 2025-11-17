<?php

declare(strict_types=1);

namespace DF;

use BackedEnum;
use DF\Exceptions\InvalidArgumentException;
use DF\Exceptions\InvalidBooleanStringException;
use DF\Exceptions\InvalidNumberSignException;
use DF\Exceptions\InvalidTypeException;
use DF\Exceptions\NotNumericException;
use DF\Exceptions\ZeroValueException;

class SmartCast
{
    /**
     * Converts a string or integer to an integer with additional validation
     *
     * @param  string|int|null  $value  The value to convert
     * @param  NumberSign|null  $sign  Expected number sign (positive, negative, or null for any)
     * @param  bool  $strictType  If true, rejects decimal values (e.g., "123.45")
     * @param  bool  $acceptsZero  If false, throws exception when value is zero
     * @param  bool  $acceptNull  If false, throws exception when value is null
     * @return int|null Converted integer value or null if accepted
     */
    public static function stringToInt(
        string|int|null $value,
        ?NumberSign $sign = null,
        bool $strictType = true,
        bool $acceptsZero = true,
        bool $acceptNull = false,
    ): ?int {
        if (static::checkNullable($value, $acceptNull) && $value === null) {
            return null;
        }

        static::checkIsNumeric($value);

        if (is_string($value)) {
            $value = preg_replace('/\.0+$/', '', $value);
        }

        if ($strictType && is_string($value) && preg_match('/\d+\.+(\d+)?/', $value) !== 0) {
            throw new InvalidTypeException($value);
        }

        $result = (int) $value;

        static::checkZeroValue($result, $acceptsZero);
        static::checkSign($result, $sign);

        return $result;
    }

    /**
     * Converts a string or integer to a float with additional validation
     *
     * @param  string|float|null  $value  The value to convert
     * @param  NumberSign|null  $sign  Expected number sign (positive, negative, or null for any)
     * @param  bool  $strictType  If true, requires decimal point in the value (e.g., "123.45")
     * @param  bool  $acceptsZero  If false, throws exception when value is zero
     * @param  bool  $acceptNull  If false, throws exception when value is null
     * @return float|null Converted float value or null if accepted
     */
    public static function stringToFloat(
        string|float|null $value,
        ?NumberSign $sign = null,
        bool $strictType = false,
        bool $acceptsZero = true,
        bool $acceptNull = false,
    ): ?float {
        if (static::checkNullable($value, $acceptNull) && $value === null) {
            return null;
        }

        static::checkIsNumeric($value);

        if ($strictType && is_string($value) && preg_match('/^\d+\.\d+$/', $value) === 0) {
            throw new InvalidTypeException($value);
        }

        $result = (float) $value;

        static::checkZeroValue($result, $acceptsZero);
        static::checkSign($result, $sign);

        return $result;
    }

    /**
     * Converts a string to a boolean value
     *
     * Supports common boolean string representations:
     * - True values: "1", "true", "on", "yes" (case-insensitive)
     * - False values: "0", "false", "off", "no" (case-insensitive)
     *
     * @param  string|bool  $value  The value to convert (string or existing boolean)
     * @return bool Converted boolean value
     */
    public static function stringToBoolean(string|bool $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if ($value === '') {
            throw new InvalidBooleanStringException($value);
        }

        $result = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        if ($result === null) {
            throw new InvalidBooleanStringException($value);
        }

        return $result;
    }

    /**
     * Ensures that a given value is a valid string and belongs to the specified set of allowed values.
     *
     * @param  string|null  $value  The value to validate.
     * @param  mixed  $allowedValues  The allowed values as an array of strings or the backed enum class name.
     * @param  bool  $acceptNull  Whether null values are accepted. If true and $value is null, returns null.
     * @param  bool  $strict  Whether to use strict type comparison (===) or loose comparison (==).
     * @return string|null The validated string value or null if nullable.
     *
     * @throws InvalidTypeException If the value is not a string or does not match any allowed value.
     * @throws InvalidArgumentException If $allowedValues is neither an array nor a valid enum class.
     */
    public static function ensureAllowedString(
        ?string $value,
        mixed $allowedValues,
        bool $acceptNull = false,
        bool $strict = true,
    ): ?string {
        if (static::checkNullable($value, $acceptNull) && $value === null) {
            return null;
        }

        $isArray = is_array($allowedValues);
        $isEnumClass = is_string($allowedValues) && enum_exists($allowedValues);
        $isBackedEnumClass = $isEnumClass && is_subclass_of($allowedValues, BackedEnum::class);

        if (!$isArray && !$isBackedEnumClass) {
            throw new InvalidArgumentException($allowedValues);
        }

        if ($isArray) {
            if (!in_array($value, $allowedValues, $strict)) {
                throw new InvalidTypeException($value);
            }

            return $value;
        }

        $comparator = $strict
            ? fn ($a, $b) => $a === $b
            : fn ($a, $b) => $a == $b;

        foreach ($allowedValues::cases() as $case) {
            if ($comparator($case->value, $value)) {
                return $case->value;
            }
        }

        throw new InvalidTypeException($value);
    }

    private static function checkIsNumeric(string|int|float $value): void
    {
        if (!is_numeric($value)) {
            throw new NotNumericException($value);
        }
    }

    private static function checkNullable(mixed $value, bool $acceptNull): bool
    {
        if ($value === null && !$acceptNull) {
            throw new InvalidTypeException($value);
        }

        return true;
    }

    private static function checkSign(int|float $value, ?NumberSign $sign): void
    {
        if ($sign === NumberSign::POSITIVE && $value < 0) {
            throw new InvalidNumberSignException((string) $value);
        }

        if ($sign === NumberSign::NEGATIVE && $value > 0) {
            throw new InvalidNumberSignException((string) $value);
        }
    }

    private static function checkZeroValue(int|float $value, bool $acceptsZero): void
    {
        if (!$acceptsZero && $value == 0) {
            throw new ZeroValueException;
        }
    }
}
