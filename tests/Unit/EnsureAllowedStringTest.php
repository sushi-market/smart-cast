<?php

declare(strict_types=1);

use DF\Exceptions\InvalidArgumentException;
use DF\Exceptions\InvalidTypeException;
use DF\SmartCast;

it('returns the value when it is allowed in array', function (string $value) {
    expect(SmartCast::ensureAllowedString($value, ['foo', 'bar', 'baz']))->toBe($value);
})->with([
    'foo',
    'bar',
    'baz',
]);

it('throws exception when value not in allowed array', function () {
    SmartCast::ensureAllowedString('test', ['foo', 'bar']);
})->throws(InvalidTypeException::class);

enum TestEnum: string
{
    case One = 'one';
    case Two = 'two';
    case Three = 'three';
}

it('returns the value when it matches enum case value', function (string $value) {
    expect(SmartCast::ensureAllowedString($value, TestEnum::class))->toBe($value);
})->with([
    'one',
    'two',
    'three',
]);

it('throws exception when value does not match enum case value', function () {
    SmartCast::ensureAllowedString('invalid', TestEnum::class);
})->throws(InvalidTypeException::class);

it('returns null when nullable and value is null', function () {
    expect(SmartCast::ensureAllowedString(null, ['a', 'b'], true))->toBeNull();
});

it('throws exception when not nullable and value is null', function () {
    SmartCast::ensureAllowedString(null, ['a', 'b'], false);
})->throws(InvalidTypeException::class);

it('throws exception when allowedValues is invalid type', function () {
    SmartCast::ensureAllowedString('a', 123);
})->throws(InvalidArgumentException::class);

it('accepts loose matches in array when strict = false', function () {
    expect(SmartCast::ensureAllowedString('1', [1, 2], false, false))->toBe('1');
});

it('rejects loose matches in array when strict = true', function () {
    SmartCast::ensureAllowedString('1', [1, 2], false, true);
})->throws(InvalidTypeException::class);
