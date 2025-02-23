<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Commitment\Application;

use JDevelop\Erp\Commitment\Application\CreateCommitment\CreateCommitmentDto;
use JDevelop\Erp\Commitment\Application\CreateCommitment\CreateCommitmentService;
use JDevelop\Erp\Commitment\Domain\Exception\CompanyNotFoundException;
use JDevelop\Erp\Commitment\Domain\Exception\CustomerNotFoundException;
use JDevelop\Erp\Commitment\Domain\Exception\InvalidDatesSequenceException;
use JDevelop\Erp\Tests\Commitment\CommitmentTest;

final class CreateCommitmentServiceTest extends CommitmentTest
{
    private readonly CreateCommitmentService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new CreateCommitmentService(
            $this->companyRepository,
            $this->customerRepository,
            $this->commitmentRepository
        );

        $this->createCompany('ExistingCompanyId');
        $this->createCustomer('ExistingCustomerId');
    }

    public function testCompanyShouldExists(): void
    {
        $this->expectException(CompanyNotFoundException::class);

        $this->service->execute(
            new CreateCommitmentDto(
                'InvalidCompanyId',
                'ExistingCustomerId',
                '2025-02-23',
                '2025-03-15',
            )
        );
    }

    public function testCustomerShouldExists(): void
    {
        $this->expectException(CustomerNotFoundException::class);

        $this->service->execute(
            new CreateCommitmentDto(
                'ExistingCompanyId',
                'InvalidCustomerId',
                '2025-02-23',
                '2025-03-15',
            )
        );
    }

    public function testDatesShouldBeValid(): void
    {
        $this->expectException(InvalidDatesSequenceException::class);

        $this->service->execute(
            new CreateCommitmentDto(
                'ExistingCompanyId',
                'ExistingCustomerId',
                '2025-03-15',
                '2025-02-23',
            )
        );
    }

    public function testCommitmentShouldBeCreated(): void
    {
        $commitmentCreatedDto = $this->service->execute(
            new CreateCommitmentDto(
                'ExistingCompanyId',
                'ExistingCustomerId',
                '2025-02-23',
                '2025-03-15',
            )
        );

        $this->assertCommitmentHasBeenCreated(
            $commitmentCreatedDto->getId(),
            'ExistingCompanyId',
            'ExistingCustomerId',
            '2025-02-23',
            '2025-03-15'
        );
    }
}
