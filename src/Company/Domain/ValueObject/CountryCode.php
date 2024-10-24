<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\ValueObject;

use JDevelop\Erp\Company\Domain\Exception\InvalidCountryCodeException;

final readonly class CountryCode
{
    private string $value;

    private function __construct(string $value)
    {
        $sanitizedValue = $this->sanitize($value);

        $this->validate($sanitizedValue);

        $this->value = $sanitizedValue;
    }

    private function sanitize(string $value): string
    {
        return trim(strtoupper($value));
    }

    private function validate(string $value): void
    {
        if (preg_match('/^[A-Z]{2}$/', $value) !== 1) {
            throw new InvalidCountryCodeException($value);
        }
    }

    public static function of(string $value): self
    {
        return new self($value);
    }

    public function unwrap(): string
    {
        return $this->value;
    }
}
