<?php

declare(strict_types=1);

namespace DF\Exceptions;

use Throwable;

class FloatOverflowException extends OverflowException
{
    public function __construct(mixed $value, ?string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        $message = $message ?? "Float overflow: {$this->prepareValue($value)}";

        parent::__construct($value, $message, $code, $previous);
    }
}
