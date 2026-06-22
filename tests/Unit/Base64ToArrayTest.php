<?php

declare(strict_types=1);

use DF\SmartCast\Exceptions\InvalidBase64StringException;
use DF\SmartCast\Exceptions\InvalidJsonStringException;
use DF\SmartCast\Exceptions\InvalidTypeException;
use DF\SmartCast\SmartCast;

it('decodes base64-encoded JSON array', function () {
    // [1,2,3]
    expect(SmartCast::base64ToArray('WzEsMiwzXQ=='))->toBe([1, 2, 3]);
});

it('decodes base64-encoded JSON object to associative array', function () {
    // {"foo":"bar","baz":42}
    expect(SmartCast::base64ToArray('eyJmb28iOiJiYXIiLCJiYXoiOjQyfQ=='))->toBe(['foo' => 'bar', 'baz' => 42]);
});

it('decodes base64-encoded empty JSON array', function () {
    // []
    expect(SmartCast::base64ToArray('W10='))->toBe([]);
});

it('decodes base64-encoded empty JSON object', function () {
    // {}
    expect(SmartCast::base64ToArray('e30='))->toBe([]);
});

it('decodes base64-encoded nested JSON structure', function () {
    // {"a":{"b":[1,2]}}
    expect(SmartCast::base64ToArray('eyJhIjp7ImIiOlsxLDJdfX0='))->toBe(['a' => ['b' => [1, 2]]]);
});

it('decodes base64-encoded JSON array with mixed types', function () {
    // [true,false,null]
    expect(SmartCast::base64ToArray('W3RydWUsZmFsc2UsbnVsbF0='))->toBe([true, false, null]);
});

it('returns null when value is null and acceptNull is true', function () {
    expect(SmartCast::base64ToArray(null, acceptNull: true))->toBeNull();
});

it('throws InvalidTypeException when value is null and acceptNull is false', function () {
    SmartCast::base64ToArray(null);
})->throws(InvalidTypeException::class);

it('throws InvalidBase64StringException for string with invalid base64 characters', function () {
    SmartCast::base64ToArray('not-valid-base64!!!');
})->throws(InvalidBase64StringException::class);

it('throws InvalidBase64StringException for string with wrong padding', function () {
    SmartCast::base64ToArray('abc!');
})->throws(InvalidBase64StringException::class);

it('throws InvalidJsonStringException when decoded value is not valid JSON', function () {
    // not json at all
    SmartCast::base64ToArray('bm90IGpzb24gYXQgYWxs');
})->throws(InvalidJsonStringException::class);

it('throws InvalidJsonStringException when decoded value is truncated JSON', function () {
    // [1,2,3  (truncated)
    SmartCast::base64ToArray('WzEsMiwz');
})->throws(InvalidJsonStringException::class);

it('throws InvalidTypeException when decoded JSON is a string scalar', function () {
    // "hello"
    SmartCast::base64ToArray('ImhlbGxvIg==');
})->throws(InvalidTypeException::class);

it('throws InvalidTypeException when decoded JSON is a number', function () {
    // 42
    SmartCast::base64ToArray('NDI=');
})->throws(InvalidTypeException::class);

it('throws InvalidTypeException when decoded JSON is a boolean', function () {
    // true
    SmartCast::base64ToArray('dHJ1ZQ==');
})->throws(InvalidTypeException::class);

it('throws InvalidTypeException when decoded JSON is null literal', function () {
    // null
    SmartCast::base64ToArray('bnVsbA==');
})->throws(InvalidTypeException::class);

it('successfully decodes various base64-encoded JSON values', function (string $input, array $expected) {
    expect(SmartCast::base64ToArray($input))->toBe($expected);
})->with([
    // [1,2,3]
    ['WzEsMiwzXQ==', [1, 2, 3]],
    // {"foo":"bar"}
    ['eyJmb28iOiJiYXIifQ==', ['foo' => 'bar']],
    // []
    ['W10=', []],
    // {}
    ['e30=', []],
    // [true,false,null]
    ['W3RydWUsZmFsc2UsbnVsbF0=', [true, false, null]],
]);
