<?php

declare(strict_types=1);

namespace JDevelop\Erp\Resource\Domain\Entity;

final class Resource
{
    public function __construct(
        private readonly Company $company,
        private readonly string $firstName,
        private readonly string $lastName,
        private ?string $id = null
    ) {
    }

    public function getCompany(): Company
    {
        return $this->company;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
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
