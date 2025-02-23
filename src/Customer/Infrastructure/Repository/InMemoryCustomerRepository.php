<?php

declare(strict_types=1);

namespace JDevelop\Erp\Customer\Infrastructure\Repository;

use JDevelop\Erp\Customer\Domain\Entity\Company;
use JDevelop\Erp\Customer\Domain\Entity\Customer;
use JDevelop\Erp\Customer\Domain\Repository\CustomerRepositoryInterface;
use JDevelop\Erp\Customer\Domain\ValueObject\RegistrationNumber;

final class InMemoryCustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @var array<string, Customer>
     */
    private iterable $customerById = [];

    /**
     * @var array<string, array<string, Customer>>
     */
    private iterable $customerByCompanyAndRegistrationNumber = [];

    private int $nextId = 1;

    public function save(Customer $customer): void
    {
        if ($customer->getId() === null) {
            $customer->setId((string)$this->nextId++);
        }

        $companyId = $customer->getCompany()->getId();
        $customerRegistrationNumber = $customer->getRegistrationNumber()->unwrap();

        $this->customerById[$customer->getId()] = $customer;
        $this->customerByCompanyAndRegistrationNumber[$companyId][$customerRegistrationNumber] = $customer;
    }

    public function existsByRegistrationNumber(Company $company, RegistrationNumber $registrationNumber): bool
    {
        return isset($this->customerByCompanyAndRegistrationNumber[$company->getId()][$registrationNumber->unwrap()]);
    }

    public function findById(string $id): ?Customer
    {
        return $this->customerById[$id] ?? null;
    }
}
