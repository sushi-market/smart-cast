<?php

declare(strict_types=1);

use DF\SmartCast\Exceptions\FloatOverflowException;
use DF\SmartCast\Exceptions\InvalidNumberSignException;
use DF\SmartCast\Exceptions\InvalidTypeException;
use DF\SmartCast\Exceptions\NotNumericException;
use DF\SmartCast\Exceptions\ZeroValueException;
use DF\SmartCast\NumberSign;
use DF\SmartCast\SmartCast;

dataset('valid floats', [
    // String floats
    ['1.5', 1.5],
    ['3.14', 3.14],
    ['0.1', 0.1],
    ['-2.5', -2.5],
    ['+0.5', 0.5],

    // String integers (should convert to float)
    ['1', 1.0],
    ['0', 0.0],
    ['-5', -5.0],
    ['123', 123.0],

    // String floats with spaces
    [' 123.123', 123.123],
    ['123.123 ', 123.123],
    [' 123.123 ', 123.123],
    ['   123.123        ', 123.123],

    // String floats with leading zeros
    ['00', 0],
    ['0123', 123.0],
    ['00123', 123.0],
    ['000123', 123.0],
    ['0000123', 123.0],
    ['0000123.0', 123.0],
    ['0000123.00', 123.0],

    // Float values directly
    [1.5, 1.5],
    [3.14, 3.14],
    [0.0, 0.0],
    [-2.5, -2.5],

    // Integer values (should convert to float)
    [1, 1.0],
    [0, 0.0],
    [-5, -5.0],
    [100, 100.0],

    // Edge cases
    ['.5', 0.5],
    ['-.25', -0.25],
    ['0.0001', 0.0001],
    ['1.7976931348623E+308', 1.7976931348623E+308],
    ['-1.7976931348623E+308', -1.7976931348623E+308],
]);

dataset('overflow floats', [
    ['1.7976931348624e+308'],
    ['1e400'],
    ['-1e400'],
    ['99999999999999999999999999'],
]);

it('successfully casts various values to float', function (mixed $value, float $expected) {
    expect(SmartCast::stringToFloat($value))->toBeFloat()->toBe($expected);
})->with('valid floats');

it('cast to float simple int value', function () {
    $result = SmartCast::stringToFloat('-1');

    expect($result)->toBeFloat()->toBe(-1.0);
});

it('return null if accepted', function () {
    $result = SmartCast::stringToFloat(null, acceptNull: true);

    expect($result)->toBeNull();
});

test('throws FloatOverflowException when the value exceeds PHP_FLOAT_MAX or PHP_FLOAT_MIN', function ($input) {
    SmartCast::stringToFloat($input);
})->throws(FloatOverflowException::class)->with('overflow floats');

it('throws error when value is null and null is not accepted', function () {
    SmartCast::stringToFloat(null);
})->throws(InvalidTypeException::class);

it('throws error if string is not numeric', function () {
    SmartCast::stringToFloat('some text');
})->throws(NotNumericException::class, 'some text');

it('throws error if string contain int numeric value, and set strict type', function () {
    SmartCast::stringToFloat('1', strictType: true);
})->throws(InvalidTypeException::class, '1');

it('throws error if string contain zero value and disabled zero acceptance', function () {
    SmartCast::stringToFloat('0.0', acceptsZero: false);
})->throws(ZeroValueException::class);

it('throws InvalidNumberSignException for sign mismatch with float values', function (mixed $value, NumberSign $sign) {
    expect(fn () => SmartCast::stringToFloat($value, $sign))
        ->toThrow(InvalidNumberSignException::class);
})->with([
    // Negative float values with POSITIVE sign
    ['-5.5', NumberSign::POSITIVE],
    ['-1.1', NumberSign::POSITIVE],
    [-10.25, NumberSign::POSITIVE],
    [-1.75, NumberSign::POSITIVE],
    ['-0.1', NumberSign::POSITIVE],
    ['-3.14', NumberSign::POSITIVE],

    // Positive float values with NEGATIVE sign
    ['5.5', NumberSign::NEGATIVE],
    ['1.1', NumberSign::NEGATIVE],
    [10.25, NumberSign::NEGATIVE],
    [1.75, NumberSign::NEGATIVE],
    ['0.1', NumberSign::NEGATIVE],
    ['3.14', NumberSign::NEGATIVE],

    // Edge cases
    ['+5.5', NumberSign::NEGATIVE],   // explicit positive with negative sign
    ['+0.1', NumberSign::NEGATIVE],   // explicit positive with negative sign
]);

it('return zero without error', function ($value, $sign) {
    $result = SmartCast::stringToFloat($value, $sign);

    expect($result)->toBeFloat()->toBe(0.0);
})->with([
    [0.0, NumberSign::POSITIVE],
    [0.0, NumberSign::NEGATIVE],
    ['0.0', NumberSign::POSITIVE],
    ['0.0', NumberSign::NEGATIVE],
]);
