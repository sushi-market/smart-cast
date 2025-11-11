<?php

declare(strict_types=1);

use DF\Exceptions\InvalidTypeException;
use DF\SmartCast;

it('casts json array string to array', function () {
    expect(SmartCast::stringToArray('[1,2,3]'))
        ->toBe([1, 2, 3]);
});

it('casts delimited string to array', function () {
    expect(SmartCast::stringToArray('1,2,3,4'))
        ->toBe([1, 2, 3, 4]);
});

it('trims items when casting delimited string', function () {
    expect(SmartCast::stringToArray('apple, banana , cherry'))
        ->toBe(['apple', 'banana', 'cherry']);
});

it('returns array values as is', function () {
    $value = ['foo', 'bar'];

    expect(SmartCast::stringToArray($value))
        ->toBe($value);
});

it('returns null if accepted', function () {
    expect(SmartCast::stringToArray(null, acceptNull: true))
        ->toBeNull();
});

it('throws error when value is null and null is not accepted', function () {
    SmartCast::stringToArray(null);
})->throws(InvalidTypeException::class);

it('throws error for invalid json string', function () {
    SmartCast::stringToArray('[1,2,3');
})->throws(InvalidTypeException::class);

it('throws error when delimited string contains empty items', function () {
    SmartCast::stringToArray('1,,3');
})->throws(InvalidTypeException::class);

