<?php

declare(strict_types=1);

namespace DF\SmartCast\Exceptions;

use Throwable;

class NotNumericException extends InvalidArgumentException
{
    public function __construct(mixed $value, ?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        $message = $message ?? "Value {$this->prepareValue($value)} is not numeric";

        parent::__construct($value, $message, $code, $previous);
    }
}
