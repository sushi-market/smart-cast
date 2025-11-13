<?php

declare(strict_types=1);

use DF\Exceptions\InvalidTypeException;
use DF\NumberSign;
use DF\SmartCast;

if (!function_exists('stringToInt')) {
    /**
     * Converts a string or integer to an integer with additional validation
     *
     * @param  string|int|null  $value  The value to convert
     * @param  NumberSign|null  $sign  Expected number sign (positive, negative, or null for any)
     * @param  bool  $strictType  If true, rejects decimal values (e.g., "123.45")
     * @param  bool  $acceptsZero  If false, throws exception when value is zero
     * @param  bool  $acceptNull  If false, throws exception when value is null
     * @return int|null Converted integer value
     */
    function stringToInt(
        string|int|null $value,
        ?NumberSign $sign = null,
        bool $strictType = true,
        bool $acceptsZero = true,
        bool $acceptNull = false,
    ): ?int {
        return SmartCast::stringToInt($value, $sign, $strictType, $acceptsZero, $acceptNull);
    }
}

if (!function_exists('stringToFloat')) {
    /**
     * Converts a string or integer to a float with additional validation
     *
     * @param  string|float|null  $value  The value to convert
     * @param  NumberSign|null  $sign  Expected number sign (positive, negative, or null for any)
     * @param  bool  $strictType  If true, requires decimal point in the value (e.g., "123.45")
     * @param  bool  $acceptsZero  If false, throws exception when value is zero
     * @param  bool  $acceptNull  If false, throws exception when value is null
     * @return float|null Converted float value
     */
    function stringToFloat(
        string|float|null $value,
        ?NumberSign $sign = null,
        bool $strictType = false,
        bool $acceptsZero = true,
        bool $acceptNull = false,
    ): ?float {
        return SmartCast::stringToFloat($value, $sign, $strictType, $acceptsZero, $acceptNull);
    }
}

if (!function_exists('stringToBoolean')) {
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
    function stringToBoolean(string|bool $value): bool
    {
        return SmartCast::stringToBoolean($value);
    }
}

if (!function_exists('ensureAllowedString')) {
    /**
     * Ensures that a given value is a valid string and belongs to the specified set of allowed values.
     *
     * @param  mixed  $value  The value to validate.
     * @param  mixed  $allowedValues  The allowed values as an array or the enum class name.
     * @param  bool  $acceptNull  Whether null values are accepted. If true and $value is null, returns null.
     * @param  bool  $strict  Whether to use strict type comparison (===) or loose comparison (==).
     * @return string|null The validated string value or null if nullable.
     *
     * @throws InvalidTypeException If the value is not a string or does not match any allowed value.
     * @throws InvalidArgumentException If $allowedValues is neither an array nor a valid enum class.
     */
    function ensureAllowedString(
        mixed $value,
        mixed $allowedValues,
        bool $acceptNull = false,
        bool $strict = true,
    ): ?string {
        return SmartCast::ensureAllowedString($value, $allowedValues, $acceptNull, $strict);
    }
}
