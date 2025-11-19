<?php

declare(strict_types=1);

use DF\SmartCast\Exceptions\InvalidBooleanStringException;
use DF\SmartCast\SmartCast;

it('casts various string values to boolean true', function (string $value) {
    expect(SmartCast::stringToBoolean($value))->toBeTrue();
})->with([
    'on',
    'yes',
    'true',
    '1',
    'ON',
    'YES',
    'TRUE',
]);

it('casts various string values to boolean false', function (string $value) {
    expect(SmartCast::stringToBoolean($value))->toBeFalse();
})->with([
    'off',
    'no',
    'false',
    '0',
    'OFF',
    'NO',
    'FALSE',
]);

it('throws error if value is not valid', function () {
    SmartCast::stringToBoolean('some value');
})->throws(InvalidBooleanStringException::class, 'some value');

it('throws error if value is empty string', function () {
    SmartCast::stringToBoolean('');
})->throws(InvalidBooleanStringException::class);
