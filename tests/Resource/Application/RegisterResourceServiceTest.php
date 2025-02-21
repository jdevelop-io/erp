<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Resource\Application;

use JDevelop\Erp\Resource\Application\RegisterResource\RegisterResourceDto;
use JDevelop\Erp\Resource\Application\RegisterResource\RegisterResourceService;
use JDevelop\Erp\Resource\Domain\Exception\CompanyNotFoundException;
use JDevelop\Erp\Tests\Resource\ResourceTest;

final class RegisterResourceServiceTest extends ResourceTest
{
    private readonly RegisterResourceService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new RegisterResourceService($this->companyRepository, $this->resourceRepository);
    }

    public function testCompanyShouldExists(): void
    {
        $this->expectException(CompanyNotFoundException::class);

        $this->service->execute(new RegisterResourceDto('InvalidCompanyId', 'John', 'DOE'));
    }

    public function testResourceShouldBeRegistered(): void
    {
        $this->createCompany('ExistingCompanyId');

        $resourceRegisteredDto = $this->service->execute(new RegisterResourceDto('ExistingCompanyId', 'John', 'DOE'));

        $this->assertResourceHasBeenRegistered($resourceRegisteredDto->getId(), 'ExistingCompanyId', 'John', 'DOE');
    }
}
