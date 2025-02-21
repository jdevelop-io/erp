<?php

declare(strict_types=1);

namespace JDevelop\Erp\Resource\Application\RegisterResource;

final readonly class RegisterResourceDto
{
    public function __construct(private string $companyId, private string $firstName, private string $lastName)
    {
    }

    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}
