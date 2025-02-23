<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Contract;

use JDevelop\Erp\Contract\Infrastructure\Repository\InMemoryCompanyRepository;
use JDevelop\Erp\Contract\Infrastructure\Repository\InMemoryContractRepository;
use JDevelop\Erp\Contract\Infrastructure\Repository\InMemoryCustomerRepository;
use JDevelop\Erp\Tests\Contract\Builder\CompanyBuilder;
use JDevelop\Erp\Tests\Contract\Builder\CustomerBuilder;
use PHPUnit\Framework\TestCase;

abstract class ContractTest extends TestCase
{
    protected readonly InMemoryCompanyRepository $companyRepository;
    protected readonly InMemoryCustomerRepository $customerRepository;
    protected readonly InMemoryContractRepository $contractRepository;
    private readonly CompanyBuilder $companyBuilder;
    private readonly CustomerBuilder $customerBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->companyRepository = new InMemoryCompanyRepository();
        $this->customerRepository = new InMemoryCustomerRepository();
        $this->contractRepository = new InMemoryContractRepository();
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

    protected function createCustomer(string $id): void
    {
        $customer = $this->customerBuilder
            ->withId($id)
            ->build();

        $this->customerRepository->save($customer);
    }

    protected function assertContractHasBeenCreated(
        string $contractId,
        string $companyId,
        string $customerId,
        string $beginDate,
        string $endDate,
        string $name,
    ): void {
        $contract = $this->contractRepository->findById($contractId);

        $this->assertNotNull($contract);
        $this->assertEquals($companyId, $contract->getCompany()->getId());
        $this->assertEquals($customerId, $contract->getCustomer()->getId());
        $this->assertEquals($beginDate, $contract->getBeginDate()->unwrap()->format('Y-m-d'));
        $this->assertEquals($endDate, $contract->getEndDate()->unwrap()->format('Y-m-d'));
        $this->assertEquals($name, $contract->getName());
    }
}
