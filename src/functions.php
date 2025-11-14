<?php

declare(strict_types=1);

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

if (!function_exists('stringToArray')) {
    /**
     * Converts a string representation into an array with additional validation
     *
     * Accepts JSON-like arrays (e.g., "[1,2,3]") or delimited strings (e.g., "1,2,3").
     *
     * @param  string|array|null  $value  The value to convert
     * @param  bool  $acceptNull  If false, throws exception when value is null
     * @param  string  $delimiter  Delimiter used for plain string lists (defaults to comma)
     * @return array|null Converted array value
     */
    function stringToArray(
        string|array|null $value,
        bool $acceptNull = false,
    ): ?array {
        return SmartCast::stringToArray($value, $acceptNull);
    }
}
