<?php

declare(strict_types=1);

namespace DF\SmartCast\Exceptions;

use LogicException;
use Throwable;

class SmartCastException extends LogicException
{
    public function __construct(
        string $message,
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        if (self::isCli()) {
            $message .= $this->buildCallTraceSuffix();
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * Find first trace frame that is not from the smart-cast vendor package.
     *
     * Normalizes backslashes to slashes to be portable on Windows.
     *
     * @return array<string,mixed>|null
     */
    private function getFirstAppFrame(): ?array
    {
        foreach ($this->getTrace() as $frame) {
            $frame['file'] = str_replace(
                search: '\\',
                replace: '/',
                subject: $frame['file'] ?? '',
            );

            if ($frame['file'] === '') {
                continue;
            }

            // Skip frames from the vendor package
            if (str_contains($frame['file'], '/vendor/sushi-market/smart-cast')) {
                continue;
            }

            return $frame;
        }

        return null;
    }

    /**
     * Returns a string like ", called in /path/to/file.php on line 123"
     * or empty string when such info cannot be determined.
     */
    private function buildCallTraceSuffix(): string
    {
        $frame = $this->getFirstAppFrame();

        if (empty($frame['file']) || empty($frame['line'])) {
            return '';
        }

        return sprintf(', called in %s on line %d', $frame['file'], (int) $frame['line']);
    }

    /**
     * Detect CLI-like environment.
     *
     * Includes phpdbg because it is commonly used interactively and for tests.
     */
    private static function isCli(): bool
    {
        return PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg';
    }
}
