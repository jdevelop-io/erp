<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Customer;

use JDevelop\Erp\Customer\Infrastructure\Repository\InMemoryCompanyRepository;
use JDevelop\Erp\Customer\Infrastructure\Repository\InMemoryCustomerRepository;
use JDevelop\Erp\Tests\Customer\Builder\CompanyBuilder;
use JDevelop\Erp\Tests\Customer\Builder\CustomerBuilder;
use PHPUnit\Framework\TestCase;

abstract class CustomerTest extends TestCase
{
    protected readonly InMemoryCompanyRepository $companyRepository;
    protected readonly InMemoryCustomerRepository $customerRepository;
    private readonly CompanyBuilder $companyBuilder;
    private readonly CustomerBuilder $customerBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->companyRepository = new InMemoryCompanyRepository();
        $this->customerRepository = new InMemoryCustomerRepository();
        $this->companyBuilder = new CompanyBuilder();
        $this->customerBuilder = new CustomerBuilder();
    }

    protected function createCompany(string $id): void
    {
        $company = $this->companyBuilder
            ->withId($id)
            ->build();

        $this->companyRepository->save($company);
    }

    protected function createCustomer(string $companyId, string $registrationNumber): void
    {
        $company = $this->companyRepository->findById($companyId);

        $customer = $this->customerBuilder
            ->withCompany($company)
            ->withRegistrationNumber($registrationNumber)
            ->build();

        $this->customerRepository->save($customer);
    }

    protected function assertCustomerHasBeenRegistered(string $customerId, string $companyId): void
    {
        $customer = $this->customerRepository->findById($customerId);

        $this->assertNotNull($customer);
        $this->assertSame($companyId, $customer->getCompany()->getId());
    }
}
