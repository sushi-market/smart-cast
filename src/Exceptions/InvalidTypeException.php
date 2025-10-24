<?php

declare(strict_types=1);

namespace DF\Exceptions;

use Throwable;

class InvalidTypeException extends InvalidArgumentException
{
    public function __construct(
        mixed $value,
        ?string $message = null,
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        $message = $message ?? "Value '{$this->prepareValue($value)}' has invalid type";

        parent::__construct($value, $message, $code, $previous);
    }
}
