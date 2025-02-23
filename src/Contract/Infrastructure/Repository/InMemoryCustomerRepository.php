<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Infrastructure\Repository;

use JDevelop\Erp\Contract\Domain\Entity\Customer;
use JDevelop\Erp\Contract\Domain\Repository\CustomerRepositoryInterface;

final class InMemoryCustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @var array<string, Customer>
     */
    private iterable $customerById = [];

    public function findById(string $id): ?Customer
    {
        return $this->customerById[$id] ?? null;
    }

    public function save(Customer $customer): void
    {
        $this->customerById[$customer->getId()] = $customer;
    }
}
