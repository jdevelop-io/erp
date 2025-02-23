<?php

declare(strict_types=1);

namespace JDevelop\Erp\Customer\Domain\Entity;

use JDevelop\Erp\Customer\Domain\ValueObject\RegistrationNumber;

final class Customer
{
    public function __construct(
        private readonly Company $company,
        private readonly RegistrationNumber $registrationNumber,
        private readonly string $name,
        private ?string $id = null
    ) {
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function getRegistrationNumber(): RegistrationNumber
    {
        return $this->registrationNumber;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}
