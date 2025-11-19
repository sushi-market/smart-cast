<?php

declare(strict_types=1);

namespace DF\SmartCast\Exceptions;

use Throwable;

class OverflowException extends InvalidArgumentException
{
    public function __construct(mixed $value, ?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        $message = $message ?? "Overflow value: {$this->prepareValue($value)}";

        parent::__construct($value, $message, $code, $previous);
    }
}
