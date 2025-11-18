<?php

declare(strict_types=1);

namespace DF\Exceptions;

use Throwable;

class IntegerOverflowException extends InvalidArgumentException
{
    public function __construct(mixed $value, ?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        $message = $message ?? "Integer overflow: {$this->prepareValue($value)}";

        parent::__construct($value, $message, $code, $previous);
    }
}
