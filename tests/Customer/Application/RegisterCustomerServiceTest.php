<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Customer\Application;

use JDevelop\Erp\Customer\Application\RegisterCustomer\RegisterCustomerDto;
use JDevelop\Erp\Customer\Application\RegisterCustomer\RegisterCustomerService;
use JDevelop\Erp\Customer\Domain\Exception\CompanyNotFoundException;
use JDevelop\Erp\Customer\Domain\Exception\CustomerAlreadyRegisteredException;
use JDevelop\Erp\Tests\Customer\CustomerTest;

final class RegisterCustomerServiceTest extends CustomerTest
{
    private readonly RegisterCustomerService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new RegisterCustomerService($this->companyRepository, $this->customerRepository);

        $this->createCompany('ExistingCompanyId');
        $this->createCustomer('ExistingCompanyId', '123456789', 'A Customer');
    }

    public function testCompanyShouldExists(): void
    {
        $this->expectException(CompanyNotFoundException::class);

        $this->service->execute(
            new RegisterCustomerDto(
                'InvalidCompanyId',
                '123456789',
                'A Customer',
            )
        );
    }

    public function testCustomerShouldNotAlreadyExists(): void
    {
        $this->expectException(CustomerAlreadyRegisteredException::class);

        $this->service->execute(
            new RegisterCustomerDto(
                'ExistingCompanyId',
                '123456789',
                'A Customer',
            )
        );
    }

    public function testCustomerShouldBeRegistered(): void
    {
        $customerRegisteredDto = $this->service->execute(
            new RegisterCustomerDto(
                'ExistingCompanyId',
                '987654321',
                'A Customer',
            )
        );

        $this->assertCustomerHasBeenRegistered($customerRegisteredDto->getId(), 'ExistingCompanyId', 'A Customer');
    }
}
