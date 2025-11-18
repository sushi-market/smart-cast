<?php

declare(strict_types=1);

use DF\Exceptions\InvalidArgumentException;
use DF\Exceptions\InvalidTypeException;
use DF\SmartCast;
use Tests\Support\Enums\BackedTestEnum;
use Tests\Support\Enums\UnitTestEnum;

dataset('valid values', [
    // array allowed values of string
    ['foo', ['foo', 'bar', 'baz']],
    ['bar', ['foo', 'bar', 'baz']],
    ['baz', ['foo', 'bar', 'baz']],

    // array allowed values of numeric
    ['1', ['1', '2', '3']],
    ['2', [1, '2', '3']],
    ['3', [1, 2, '3']],

    // enum allowed values
    ['one', BackedTestEnum::class],
    ['two', BackedTestEnum::class],
    ['three', BackedTestEnum::class],
]);

dataset('valid nullable values', [
    // array allowed values
    [null, ['foo', 'bar', 'baz']],

    // enum allowed values
    [null, BackedTestEnum::class],
]);

dataset('valid not strict values', [
    // array allowed values of numeric
    ['2', ['1', 2, '3']],
]);

dataset('invalid values', [
    // array allowed values
    ['invalid', ['foo', 'bar', 'baz']],
    [null, ['foo', 'bar', 'baz']],

    // array allowed values of numeric
    ['1', [1, 2, '3']],
    ['2', ['1', 2, '3']],
    ['3', [1, 2, 3]],
    [null, ['1', 2, '3']],

    // enum allowed values
    ['invalid', BackedTestEnum::class],
    [null, BackedTestEnum::class],
]);

it('returns the value when it is allowed in array', function ($value, $allowed): void {
    expect(SmartCast::ensureAllowedString(
        value: $value,
        allowedValues: $allowed,
    ))->toBe($value);
})->with('valid values');

it('returns the value when it is allowed in array and acceptNull', function ($value, $allowed) {
    expect(SmartCast::ensureAllowedString(
        value: $value,
        allowedValues: $allowed,
        acceptNull: true,
    ))->toBe($value);
})->with('valid nullable values');

it('accepts loose matches in array when strict = false', function ($value, $allowed) {
    expect(SmartCast::ensureAllowedString(
        value: $value,
        allowedValues: $allowed,
        strict: false,
    ))->toBe($value);
})->with('valid not strict values');

it('throws exception when value not in allowed array', function ($value, $allowed) {
    SmartCast::ensureAllowedString($value, $allowed);
})->throws(InvalidTypeException::class)->with('invalid values');

it('throws exception when enum is not backed', function () {
    SmartCast::ensureAllowedString('Foo', UnitTestEnum::class);
})->throws(InvalidArgumentException::class);

it('throws exception when string allowedValues is not an enum', function () {
    SmartCast::ensureAllowedString('value', stdClass::class);
})->throws(InvalidArgumentException::class);
