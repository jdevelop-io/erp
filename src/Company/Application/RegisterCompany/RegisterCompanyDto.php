<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Application\RegisterCompany;

final readonly class RegisterCompanyDto
{
    public function __construct(private string $registrationNumber, private string $name)
    {
    }

    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
