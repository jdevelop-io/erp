<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Availability;

use JDevelop\Erp\Availability\Infrastructure\Repository\InMemoryResourceRepository;
use JDevelop\Erp\Availability\Infrastructure\Repository\InMemoryWorkScheduleRepository;
use JDevelop\Erp\Tests\Availability\Builder\ResourceBuilder;
use PHPUnit\Framework\TestCase;

abstract class WorkScheduleTest extends TestCase
{
    protected readonly InMemoryResourceRepository $resourceRepository;
    protected readonly InMemoryWorkScheduleRepository $workScheduleRepository;
    private readonly ResourceBuilder $resourceBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resourceRepository = new InMemoryResourceRepository();
        $this->workScheduleRepository = new InMemoryWorkScheduleRepository();
        $this->resourceBuilder = new ResourceBuilder();
    }

    protected function createResource(string $id): void
    {
        $resource = $this->resourceBuilder
            ->withId($id)
            ->build();

        $this->resourceRepository->save($resource);
    }

    protected function assertWorkScheduleShouldBeDefined(string $id): void
    {
        $workSchedule = $this->workScheduleRepository->findById($id);

        $this->assertNotNull($workSchedule);
    }
}
