<?php

declare(strict_types=1);

namespace JDevelop\Erp\Customer\Domain\Repository;

use JDevelop\Erp\Customer\Domain\Entity\Company;
use JDevelop\Erp\Customer\Domain\Entity\Customer;
use JDevelop\Erp\Customer\Domain\ValueObject\RegistrationNumber;

interface CustomerRepositoryInterface
{
    public function save(Customer $customer): void;

    public function existsByRegistrationNumber(Company $company, RegistrationNumber $registrationNumber): bool;

    public function findById(string $id): ?Customer;
}
