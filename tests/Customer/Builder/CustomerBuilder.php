<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Customer\Builder;

use JDevelop\Erp\Customer\Domain\Entity\Company;
use JDevelop\Erp\Customer\Domain\Entity\Customer;
use JDevelop\Erp\Customer\Domain\ValueObject\RegistrationNumber;
use JDevelop\Erp\Customer\Domain\ValueObject\Siren;

final class CustomerBuilder
{
    private Company $company;
    private RegistrationNumber $registrationNumber;

    public function withCompany(Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function withRegistrationNumber(string $registrationNumber): self
    {
        $this->registrationNumber = new Siren($registrationNumber);

        return $this;
    }

    public function build(): Customer
    {
        return new Customer($this->company, $this->registrationNumber);
    }
}
