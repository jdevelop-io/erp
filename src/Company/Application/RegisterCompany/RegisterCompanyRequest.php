<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Application\RegisterCompany;

final readonly class RegisterCompanyRequest
{
    public function __construct(private string $registrationNumber, private string $countryCode)
    {
    }

    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }
}
