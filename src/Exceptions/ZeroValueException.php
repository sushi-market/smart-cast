<?php

declare(strict_types=1);

namespace DF\Exceptions;

use Throwable;

class ZeroValueException extends SmartCastException
{
    public function __construct(
        string $message = 'Zero value is not accepted',
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
