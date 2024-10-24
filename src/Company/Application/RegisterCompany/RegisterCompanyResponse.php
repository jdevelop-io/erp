<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Application\RegisterCompany;

final readonly class RegisterCompanyResponse
{
    private function __construct(private ?string $registrationNumber = null, private ?string $errorKey = null)
    {
    }

    public static function fail(string $errorKey): self
    {
        return new self(errorKey: $errorKey);
    }

    public static function success(string $registrationNumber): self
    {
        return new self(registrationNumber: $registrationNumber);
    }

    public function isFailure(): bool
    {
        return $this->errorKey !== null;
    }

    public function isSuccessful(): bool
    {
        return $this->registrationNumber !== null;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function getErrorKey(): string
    {
        return $this->errorKey;
    }
}
