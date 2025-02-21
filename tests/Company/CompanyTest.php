<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Company;

use JDevelop\Erp\Company\Infrastructure\Repository\InMemoryCompanyRepository;
use JDevelop\Erp\Tests\Company\Builder\CompanyBuilder;
use PHPUnit\Framework\TestCase;

abstract class CompanyTest extends TestCase
{
    protected readonly InMemoryCompanyRepository $companyRepository;
    private readonly CompanyBuilder $companyBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->companyRepository = new InMemoryCompanyRepository();
        $this->companyBuilder = new CompanyBuilder();
    }

    protected function createCompany(string $registrationNumber, string $name): void
    {
        $company = $this->companyBuilder
            ->withRegistrationNumber($registrationNumber)
            ->withName($name)
            ->build();

        $this->companyRepository->save($company);
    }

    protected function assertCompanyHasBeenRegistered(string $registrationNumber, string $name): void
    {
        $company = $this->companyRepository->findByRegistrationNumber($registrationNumber);
        $this->assertNotNull($company);
        $this->assertEquals($name, $company->getName());
    }
}
