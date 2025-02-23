<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Contract\Application;

use JDevelop\Erp\Contract\Application\CreateContract\CreateContractDto;
use JDevelop\Erp\Contract\Application\CreateContract\CreateContractService;
use JDevelop\Erp\Contract\Domain\Exception\CompanyNotFoundException;
use JDevelop\Erp\Contract\Domain\Exception\CustomerNotFoundException;
use JDevelop\Erp\Contract\Domain\Exception\InvalidDatesSequenceException;
use JDevelop\Erp\Tests\Contract\ContractTest;

final class CreateContractServiceTest extends ContractTest
{
    private readonly CreateContractService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new CreateContractService(
            $this->companyRepository,
            $this->customerRepository,
            $this->contractRepository
        );

        $this->createCompany('ExistingCompanyId');
        $this->createCustomer('ExistingCustomerId');
    }

    public function testCompanyShouldExists(): void
    {
        $this->expectException(CompanyNotFoundException::class);

        $this->service->execute(
            new CreateContractDto(
                'InvalidCompanyId',
                'ExistingCustomerId',
                '2025-02-23',
                '2025-03-15',
                'A contract',
            )
        );
    }

    public function testCustomerShouldExists(): void
    {
        $this->expectException(CustomerNotFoundException::class);

        $this->service->execute(
            new CreateContractDto(
                'ExistingCompanyId',
                'InvalidCustomerId',
                '2025-02-23',
                '2025-03-15',
                'A contract',
            )
        );
    }

    public function testDatesShouldBeValid(): void
    {
        $this->expectException(InvalidDatesSequenceException::class);

        $this->service->execute(
            new CreateContractDto(
                'ExistingCompanyId',
                'ExistingCustomerId',
                '2025-03-15',
                '2025-02-23',
                'A contract',
            )
        );
    }

    public function testContractShouldBeCreated(): void
    {
        $contractCreatedDto = $this->service->execute(
            new CreateContractDto(
                'ExistingCompanyId',
                'ExistingCustomerId',
                '2025-02-23',
                '2025-03-15',
                'A contract',
            )
        );

        $this->assertContractHasBeenCreated(
            $contractCreatedDto->getId(),
            'ExistingCompanyId',
            'ExistingCustomerId',
            '2025-02-23',
            '2025-03-15',
            'A contract',
        );
    }
}
