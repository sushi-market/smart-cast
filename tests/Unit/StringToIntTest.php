<?php

declare(strict_types=1);

use DF\Exceptions\IntegerOverflowException;
use DF\Exceptions\InvalidNumberSignException;
use DF\Exceptions\InvalidTypeException;
use DF\Exceptions\NotNumericException;
use DF\Exceptions\ZeroValueException;
use DF\NumberSign;
use DF\SmartCast;

dataset('valid integers', [
    'php_int_max' => ['9223372036854775807', PHP_INT_MAX],
    'php_int_min' => ['-9223372036854775808', PHP_INT_MIN],
    'zero' => ['0', 0],
    'positive' => ['5', 5],
    'negative' => ['-5', -5],
    'with_plus' => ['+123', 123],
    'leading_zeros' => ['000123', 123],
    'trailing_dot_zero' => ['123.0', 123],
]);

dataset('overflow integers', [
    'just_above_max' => ['9223372036854775808'],
    'much_above' => ['9999999999999999999999999'],
    'just_below_min' => ['-9223372036854775809'],
    'just_below_min_with_dot' => ['-9223372036854775809.0'],
]);

it('successfully casts various values to integer', function (mixed $value, int $expected) {
    expect(SmartCast::stringToInt($value))->toBeInt()->toBe($expected);
})->with([
    // String integers
    ['1', 1],
    ['123', 123],
    ['0', 0],
    ['-5', -5],
    ['+10', 10],

    // Float-like strings that are essentially integers
    ['1.0', 1],
    ['2.00', 2],
    ['-3.0', -3],
    ['0.00', 0],
    ['123.000', 123],

    // Integer values directly
    [1, 1],
    [0, 0],
    [-5, -5],
    [123, 123],
]);

it('cast to int trailing zero float value', function () {
    $result = SmartCast::stringToInt('1.0');

    expect($result)->toBeInt()->toBe(1);
});

it('cast to int float value if strict type is false', function () {
    $result = SmartCast::stringToInt('1.5', strictType: false);

    expect($result)->toBeInt()->toBe(1);
});

it('return null if accepted', function () {
    $result = SmartCast::stringToInt(null, acceptNull: true);

    expect($result)->toBeNull();
});

it('cast a valid integer when the value fits within PHP_INT_MAX', function (mixed $value, int $expected) {
    $result = SmartCast::stringToInt($value);

    expect($result)->toBeInt()->toBe($expected);
})->with('valid integers');

it('throws IntegerOverflowException when the numeric string exceeds PHP integer range', function (string $input) {
    SmartCast::stringToInt($input);
})->throws(IntegerOverflowException::class)->with('overflow integers');

it('throws error when value is null and null is not accepted', function () {
    SmartCast::stringToInt(null);
})->throws(InvalidTypeException::class);

it('throws error if string is float', function () {
    SmartCast::stringToInt('-1.1');
})->throws(InvalidTypeException::class);

it('throws error if string is invalid float', function () {
    SmartCast::stringToInt('1...0');
})->throws(NotNumericException::class);

it('throws error if string is not numeric', function () {
    SmartCast::stringToInt('some text');
})->throws(NotNumericException::class, 'some text');

it('throws error if string contain zero value and disabled zero acceptance', function () {
    SmartCast::stringToInt('0', acceptsZero: false);
})->throws(ZeroValueException::class);

it('throws InvalidNumberSignException for sign mismatch with integer values', function (mixed $value, NumberSign $sign) {
    expect(fn () => SmartCast::stringToInt($value, $sign))
        ->toThrow(InvalidNumberSignException::class);
})->with([
    // Negative integer values with POSITIVE sign
    ['-5', NumberSign::POSITIVE],
    ['-1', NumberSign::POSITIVE],
    [-10, NumberSign::POSITIVE],
    [-1, NumberSign::POSITIVE],
    ['-1.0', NumberSign::POSITIVE],
    ['-5.00', NumberSign::POSITIVE],

    // Positive integer values with NEGATIVE sign
    ['5', NumberSign::NEGATIVE],
    ['1', NumberSign::NEGATIVE],
    [10, NumberSign::NEGATIVE],
    [1, NumberSign::NEGATIVE],
    ['1.0', NumberSign::NEGATIVE],
    ['5.00', NumberSign::NEGATIVE],

    // Edge cases
    ['+5', NumberSign::NEGATIVE],
    ['+1.0', NumberSign::NEGATIVE],
]);

it('return zero without error', function ($value, $sign) {
    $result = SmartCast::stringToInt($value, $sign);

    expect($result)->toBeInt()->toBe(0);
})->with([
    [0, NumberSign::POSITIVE],
    [0, NumberSign::NEGATIVE],
    ['0', NumberSign::POSITIVE],
    ['0', NumberSign::NEGATIVE],
]);
