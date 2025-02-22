<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Availability;

use JDevelop\Erp\Availability\Infrastructure\Repository\InMemoryPublicHolidayRepository;
use JDevelop\Erp\Availability\Infrastructure\Repository\InMemoryResourceRepository;
use JDevelop\Erp\Availability\Infrastructure\Repository\InMemoryWorkScheduleRepository;
use JDevelop\Erp\Tests\Availability\Builder\PublicHolidayBuilder;
use JDevelop\Erp\Tests\Availability\Builder\ResourceBuilder;
use JDevelop\Erp\Tests\Availability\Builder\WorkScheduleBuilder;
use PHPUnit\Framework\TestCase;

abstract class WorkScheduleTest extends TestCase
{
    protected readonly InMemoryResourceRepository $resourceRepository;
    protected readonly InMemoryWorkScheduleRepository $workScheduleRepository;
    protected readonly InMemoryPublicHolidayRepository $publicHolidayRepository;
    private readonly ResourceBuilder $resourceBuilder;
    private readonly WorkScheduleBuilder $workScheduleBuilder;
    private readonly PublicHolidayBuilder $publicHolidayBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resourceRepository = new InMemoryResourceRepository();
        $this->workScheduleRepository = new InMemoryWorkScheduleRepository();
        $this->publicHolidayRepository = new InMemoryPublicHolidayRepository();
        $this->resourceBuilder = new ResourceBuilder();
        $this->workScheduleBuilder = new WorkScheduleBuilder();
        $this->publicHolidayBuilder = new PublicHolidayBuilder();
    }

    protected function createResource(string $id): void
    {
        $resource = $this->resourceBuilder
            ->withId($id)
            ->build();

        $this->resourceRepository->save($resource);
    }

    protected function createWorkSchedule(string $resourceId, array $configuration): void
    {
        $resource = $this->resourceRepository->findById($resourceId);

        $workSchedule = $this->workScheduleBuilder
            ->withResource($resource)
            ->withConfiguration($configuration)
            ->build();

        $this->workScheduleRepository->save($workSchedule);
    }

    protected function createPublicHoliday(string $date): void
    {
        $publicHoliday = $this->publicHolidayBuilder
            ->withDate($date)
            ->build();

        $this->publicHolidayRepository->save($publicHoliday);
    }

    protected function assertWorkScheduleShouldBeDefined(string $id): void
    {
        $workSchedule = $this->workScheduleRepository->findByResourceId($id);

        $this->assertNotNull($workSchedule);
    }
}
