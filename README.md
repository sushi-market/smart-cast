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

// Convert string to integer
$intValue = SmartCast::stringToInt('123'); // Returns 123

// Convert with sign validation
$positiveInt = SmartCast::stringToInt('456', NumberSign::POSITIVE);

// Convert to float
$floatValue = SmartCast::stringToFloat('123.45'); // Returns 123.45

// Convert to boolean
$boolValue = SmartCast::stringToBoolean('true'); // Returns true
```
