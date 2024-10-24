<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\ValueObject;

use JDevelop\Erp\Company\Domain\Exception\InvalidRegistrationNumberException;

abstract class RegistrationNumber
{
    private readonly string $value;

    protected function __construct(string $value)
    {
        $sanitizedValue = $this->sanitize($value);

        $this->validate($sanitizedValue);

        $this->value = $sanitizedValue;
    }

    protected function sanitize(string $value): string
    {
        return trim($value);
    }

    protected function validate(string $value): void
    {
        if (empty($value)) {
            throw new InvalidRegistrationNumberException($value);
        }
    }

    public function unwrap(): string
    {
        return $this->value;
    }
}
