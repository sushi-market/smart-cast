<?php

declare(strict_types=1);

namespace DF\Exceptions;

use Throwable;

class InvalidArgumentException extends SmartCastException
{
    public function __construct(
        private readonly mixed $value,
        ?string $message = null,
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        $message = $message ?? "Invalid argument {$this->prepareValue($this->value)}";

        parent::__construct($message, $code, $previous);
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    protected function prepareValue($value): mixed
    {
        $valueType = gettype($value);

        return is_scalar($value) ? (string) $value : $valueType;
    }
}
