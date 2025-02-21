<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Application\RegisterCompany;

final readonly class CompanyRegisteredDto
{
    public function __construct(private string $registrationNumber)
    {
    }

    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }
}
