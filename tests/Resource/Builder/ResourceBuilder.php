<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Resource\Builder;

use JDevelop\Erp\Resource\Domain\Entity\Company;
use JDevelop\Erp\Resource\Domain\Entity\Resource;

final class ResourceBuilder
{
    private Company $company;
    private string $firstName;
    private string $lastName;
    private ?string $id = null;

    public function withCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function withFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function withLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function withId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function build(): Resource
    {
        return new Resource($this->company, $this->firstName, $this->lastName);
    }
}
