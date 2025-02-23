<?php

declare(strict_types=1);

namespace JDevelop\Erp\Customer\Application\RegisterCustomer;

final readonly class RegisterCustomerDto
{
    public function __construct(private string $companyId, private string $registrationNumber, private string $name)
    {
    }

    public function getCompanyId(): string
    {
        return $this->companyId;
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
