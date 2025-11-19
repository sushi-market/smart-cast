<?php

declare(strict_types=1);

use DF\SmartCast\Exceptions\InvalidTypeException;
use DF\SmartCast\SmartCast;

it('casts json array string to array', function () {
    expect(SmartCast::stringToArray('[1,2,3]'))
        ->toBe([1, 2, 3]);
});

it('casts delimited string to array', function () {
    expect(SmartCast::stringToArray('1,2,3,4'))
        ->toBe([1, 2, 3, 4]);
});

it('casts json array with numeric strings to numbers', function () {
    expect(SmartCast::stringToArray('["1","02","foo"]'))
        ->toBe([1, 2, 'foo']);
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

it('casts json array with nested arrays recursively', function () {
    expect(SmartCast::stringToArray('[1,[2,"3"],[4,["5"]]]'))
        ->toBe([1, [2, 3], [4, [5]]]);
});

it('throws error for invalid json string', function () {
    SmartCast::stringToArray('[1,2,3');
})->throws(InvalidTypeException::class);

it('throws error for another invalid json string', function () {
    SmartCast::stringToArray('1,2,3]');
})->throws(InvalidTypeException::class);

it('throws error when delimited string contains empty items', function () {
    SmartCast::stringToArray('1,,3');
})->throws(InvalidTypeException::class);

it('throws error when delimited string contains empty items with spaces', function () {
    SmartCast::stringToArray('1 , , 2');
})->throws(InvalidTypeException::class);

it('throws error for invalid values', function (mixed $value) {
    SmartCast::stringToArray($value);
})->throws(InvalidTypeException::class)->with([
    '',
    '   ',
    '[',
    ']',
    '[,]',
    '[1,,2]',
    '[1,2,3',
    '1,2,3]',
    '1,,3',
    '1 , , 2',
]);

it('casts json array with booleans and null values', function () {
    expect(SmartCast::stringToArray('[true,false,null]'))
        ->toBe([true, false, null]);
});

it('returns empty array when given an empty json array string', function () {
    expect(SmartCast::stringToArray('[]'))
        ->toBe([]);
});

it('successfully casts various values to array', function (mixed $value, array $expected) {
    expect(SmartCast::stringToArray($value))->toBe($expected);
})->with([
    // JSON arrays
    ['[1,2,3]', [1, 2, 3]],
    ['[1.0,2,3.5]', [1.0, 2, 3.5]],
    ['[-1.0,-2,3]', [-1.0, -2, 3]],
    ['["1","02","foo"]', [1, 2, 'foo']],
    ['[true,false,null]', [true, false, null]],
    ['[1,[2,"3"],[4,["5"]]]', [1, [2, 3], [4, [5]]]],
    ['[]', []],

    // Delimited strings
    ['1,2,3,4', [1, 2, 3, 4]],
    ['apple, banana , cherry', ['apple', 'banana', 'cherry']],
    ['42', [42]],
    ['apple', ['apple']],

    // Array inputs remain unchanged
    [['foo', 'bar'], ['foo', 'bar']],
]);
