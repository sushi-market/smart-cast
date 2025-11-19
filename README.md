# 🔮 Smart Cast for PHP

[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://php.net)
[![Latest Version](https://img.shields.io/github/release/sushi-market/smart-cast.svg?style=flat-square)](https://github.com/sushi-market/smart-cast/releases)
[![Total Downloads](https://img.shields.io/packagist/dt/sushi-market/smart-cast.svg?style=flat-square)](https://packagist.org/packages/sushi-market/smart-cast)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

**Smart Cast** - An elegant and type-safe library for intelligent type casting in PHP. Eliminate boilerplate code and work with data confidently!

## ✨ Features

- 🎯 **Intuitive API** - Simple and clear syntax
- 🛡️ **Type Safety** - Comprehensive validation and exception handling
- 🚀 **Performance** - Optimized conversions with minimal overhead
- 📦 **Zero Dependencies** - No external dependencies required

## 🚀 Quick Start

### Installation

```bash
composer require sushi-market/smart-cast
```

```php
<?php

use DF\SmartCast\SmartCast;
use DF\SmartCast\NumberSign;

// Convert string to integer with strict type
$intValue = SmartCast::stringToInt('123', strictType: false); // Returns 123

// Convert with sign and zero validation
$positiveInt = SmartCast::stringToInt('456', sign: NumberSign::POSITIVE, acceptsZero: false);

// Convert to float with null validation
$floatValue = SmartCast::stringToFloat('123.45', acceptNull: false); // Returns 123.45

// Convert to boolean
$boolValue = SmartCast::stringToBoolean('true'); // Returns true

// Convert JSON-like array string
$array = SmartCast::stringToArray('[1,2,3]'); // Returns: [1, 2, 3]

// Convert delimited string to array
$array = SmartCast::stringToArray('1,2,3,4'); // Returns: [1, 2, 3, 4]

// Validate against array of allowed values
$status = SmartCast::ensureAllowedString(
    value: 'foo',
    allowedValues: ['foo', 'bar', 'baz']
); // Returns: 'foo'

// Validate against backed enum
$role = SmartCast::ensureAllowedString(
    value: 'admin',
    allowedValues: UserRoleEnum::class
); // Returns: 'admin'
```
or use helpers

```php
<?php

// Convert string to integer with strict type
$intValue = stringToInt('123', strictType: false); // Returns 123

// Convert with sign and zero validation
$positiveInt = stringToInt('456', sign: NumberSign::POSITIVE, acceptsZero: false);

// Convert to float with null validation
$floatValue = stringToFloat('123.45', acceptNull: false); // Returns 123.45

// Convert to boolean
$boolValue = stringToBoolean('true'); // Returns true

// Convert JSON-like array string
$array = stringToArray('[1,2,3]'); // Returns: [1, 2, 3]

// Convert delimited string to array
$array = stringToArray('1,2,3,4'); // Returns: [1, 2, 3, 4]

// Validate against array of allowed values
$status = ensureAllowedString(
    value: 'foo',
    allowedValues: ['foo', 'bar', 'baz']
); // Returns: 'foo'

// Validate against backed enum
$role = ensureAllowedString(
    value: 'admin',
    allowedValues: UserRoleEnum::class
); // Returns: 'admin'
```



