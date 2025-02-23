<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Commitment;

use JDevelop\Erp\Commitment\Infrastructure\Repository\InMemoryCommitmentRepository;
use JDevelop\Erp\Commitment\Infrastructure\Repository\InMemoryCompanyRepository;
use JDevelop\Erp\Commitment\Infrastructure\Repository\InMemoryCustomerRepository;
use JDevelop\Erp\Tests\Commitment\Builder\CompanyBuilder;
use JDevelop\Erp\Tests\Commitment\Builder\CustomerBuilder;
use PHPUnit\Framework\TestCase;

abstract class CommitmentTest extends TestCase
{
    protected readonly InMemoryCompanyRepository $companyRepository;
    protected readonly InMemoryCustomerRepository $customerRepository;
    protected readonly InMemoryCommitmentRepository $commitmentRepository;
    private readonly CompanyBuilder $companyBuilder;
    private readonly CustomerBuilder $customerBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->companyRepository = new InMemoryCompanyRepository();
        $this->customerRepository = new InMemoryCustomerRepository();
        $this->commitmentRepository = new InMemoryCommitmentRepository();
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

    protected function assertCommitmentHasBeenCreated(
        string $commitmentId,
        string $companyId,
        string $customerId,
        string $beginDate,
        string $endDate
    ): void {
        $commitment = $this->commitmentRepository->findById($commitmentId);

        $this->assertNotNull($commitment);
        $this->assertEquals($companyId, $commitment->getCompany()->getId());
        $this->assertEquals($customerId, $commitment->getCustomer()->getId());
        $this->assertEquals($beginDate, $commitment->getBeginDate()->unwrap()->format('Y-m-d'));
        $this->assertEquals($endDate, $commitment->getEndDate()->unwrap()->format('Y-m-d'));
    }
}
