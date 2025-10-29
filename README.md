# 🔮 Smart Cast for PHP

[![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-blue.svg)](https://php.net)
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

use DF\SmartCast;
use DF\NumberSign;

// Convert string to integer with strict type
$intValue = SmartCast::stringToInt('123', strictType: false); // Returns 123

// Convert with sign and zero validation
$positiveInt = SmartCast::stringToInt('456', sign: NumberSign::POSITIVE, acceptsZero: false);

// Convert to float with null validation
$floatValue = SmartCast::stringToFloat('123.45', acceptNull: false); // Returns 123.45

// Convert to boolean
$boolValue = SmartCast::stringToBoolean('true'); // Returns true
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
```



