<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\ValueObject;

abstract readonly class RegistrationNumber
{
    public function __construct(private string $value)
    {
    }

    public function unwrap(): string
    {
        return $this->value;
    }
}
