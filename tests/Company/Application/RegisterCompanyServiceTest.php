<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Company\Application;

use JDevelop\Erp\Company\Application\RegisterCompany\RegisterCompanyDto;
use JDevelop\Erp\Company\Application\RegisterCompany\RegisterCompanyService;
use JDevelop\Erp\Company\Domain\Exception\CompanyAlreadyRegisteredException;
use JDevelop\Erp\Company\Domain\Exception\InvalidRegistrationNumberException;
use JDevelop\Erp\Tests\Company\CompanyTest;

final class RegisterCompanyServiceTest extends CompanyTest
{
    private readonly RegisterCompanyService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new RegisterCompanyService($this->companyRepository);
    }

    public function testRegistrationNumberShouldBeASiren(): void
    {
        $this->expectException(InvalidRegistrationNumberException::class);

        $this->service->execute(
            new RegisterCompanyDto(
                'InvalidRegistrationNumber',
                'Company Name',
            )
        );
    }

    public function testRegistrationNumberShouldBeUnique(): void
    {
        $this->createCompany('123456789', 'Company Name');

        $this->expectException(CompanyAlreadyRegisteredException::class);

        $this->service->execute(
            new RegisterCompanyDto(
                '123456789',
                'Company Name',
            )
        );
    }

    public function testCompanyShouldBeRegistered(): void
    {
        $companyRegisteredDto = $this->service->execute(
            new RegisterCompanyDto(
                '123456789',
                'Company Name',
            )
        );

        $this->assertCompanyHasBeenRegistered($companyRegisteredDto->getRegistrationNumber(), 'Company Name');
    }
}
