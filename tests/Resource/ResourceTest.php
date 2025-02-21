<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Resource;

use JDevelop\Erp\Resource\Infrastructure\Repository\InMemoryCompanyRepository;
use JDevelop\Erp\Resource\Infrastructure\Repository\InMemoryResourceRepository;
use JDevelop\Erp\Tests\Resource\Builder\CompanyBuilder;
use JDevelop\Erp\Tests\Resource\Builder\ResourceBuilder;
use PHPUnit\Framework\TestCase;

abstract class ResourceTest extends TestCase
{
    protected readonly InMemoryCompanyRepository $companyRepository;
    protected readonly InMemoryResourceRepository $resourceRepository;
    private readonly CompanyBuilder $companyBuilder;
    private readonly ResourceBuilder $resourceBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->companyRepository = new InMemoryCompanyRepository();
        $this->resourceRepository = new InMemoryResourceRepository();
        $this->companyBuilder = new CompanyBuilder();
        $this->resourceBuilder = new ResourceBuilder();
    }

    protected function createCompany(string $id): void
    {
        $company = $this->companyBuilder
            ->withId($id)
            ->build();

        $this->companyRepository->save($company);
    }

    protected function assertResourceHasBeenRegistered(
        string $id,
        string $companyId,
        string $firstName,
        string $lastName
    ): void {
        $resource = $this->resourceRepository->findById($id);

        $this->assertNotNull($resource);
        $this->assertEquals($companyId, $resource->getCompany()->getId());
        $this->assertEquals($firstName, $resource->getFirstName());
        $this->assertEquals($lastName, $resource->getLastName());
    }
}
