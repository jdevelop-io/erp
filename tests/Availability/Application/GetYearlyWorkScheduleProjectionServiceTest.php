<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Availability\Application;

use JDevelop\Erp\Availability\Application\GetYearlyWorkScheduleProjection\GetYearlyWorkScheduleProjectionDto;
use JDevelop\Erp\Availability\Application\GetYearlyWorkScheduleProjection\GetYearlyWorkScheduleProjectionService;
use JDevelop\Erp\Availability\Domain\Exception\ResourceNotFoundException;
use JDevelop\Erp\Availability\Domain\Exception\WorkScheduleNotFoundException;
use JDevelop\Erp\Availability\Domain\Service\YearlyWorkScheduleProjectionService;
use JDevelop\Erp\Tests\Availability\WorkScheduleTest;

final class GetYearlyWorkScheduleProjectionServiceTest extends WorkScheduleTest
{
    private const array WORK_SCHEDULE = [
        'monday' => [
            'type' => 'work',
            'times' => [
                ['start' => '09:00', 'end' => '12:30'],
                ['start' => '14:00', 'end' => '17:00']
            ]
        ],
        'tuesday' => [
            'type' => 'work',
            'times' => [
                ['start' => '09:00', 'end' => '12:30'],
                ['start' => '14:00', 'end' => '17:00']
            ]
        ],
        'wednesday' => [
            'type' => 'work',
            'times' => [
                ['start' => '09:00', 'end' => '12:30'],
                ['start' => '14:00', 'end' => '17:00']
            ]
        ],
        'thursday' => [
            'type' => 'work',
            'times' => [
                ['start' => '09:00', 'end' => '12:30'],
                ['start' => '14:00', 'end' => '17:00']
            ]
        ],
        'friday' => [
            'type' => 'work',
            'times' => [
                ['start' => '09:00', 'end' => '12:30'],
                ['start' => '14:00', 'end' => '17:00']
            ]
        ],
        'saturday' => [
            'type' => 'off',
            'times' => []
        ],
        'sunday' => [
            'type' => 'off',
            'times' => []
        ]
    ];
    private readonly YearlyWorkScheduleProjectionService $yearlyWorkScheduleProjectionService;
    private readonly GetYearlyWorkScheduleProjectionService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->yearlyWorkScheduleProjectionService = new YearlyWorkScheduleProjectionService();

        $this->service = new GetYearlyWorkScheduleProjectionService(
            $this->resourceRepository,
            $this->workScheduleRepository,
            $this->yearlyWorkScheduleProjectionService
        );

        $this->createResource('ExistingResourceIdWithoutWorkSchedule');

        $this->createResource('ExistingResourceId');
        $this->createWorkSchedule('ExistingResourceId', self::WORK_SCHEDULE);
    }

    public function testResourceShouldExists(): void
    {
        $this->expectException(ResourceNotFoundException::class);

        $this->service->execute(new GetYearlyWorkScheduleProjectionDto('InvalidResourceId', 2025));
    }

    public function testWorkScheduleExists(): void
    {
        $this->expectException(WorkScheduleNotFoundException::class);

        $this->service->execute(new GetYearlyWorkScheduleProjectionDto('ExistingResourceIdWithoutWorkSchedule', 2025));
    }

    public function testProjectionShouldReturn260DaysFor2025(): void
    {
        $projection = $this->service->execute(new GetYearlyWorkScheduleProjectionDto('ExistingResourceId', 2025));

        $this->assertCount(261, $projection->getDates());
    }

    public function testProjectionShouldReturn261DaysFor2026(): void
    {
        $projection = $this->service->execute(new GetYearlyWorkScheduleProjectionDto('ExistingResourceId', 2026));

        $this->assertCount(261, $projection->getDates());
    }

    public function testProjectionShouldReturn261DaysFor2027(): void
    {
        $projection = $this->service->execute(new GetYearlyWorkScheduleProjectionDto('ExistingResourceId', 2027));

        $this->assertCount(261, $projection->getDates());
    }

    public function testProjectionShouldReturn260DaysFor2028(): void
    {
        $projection = $this->service->execute(new GetYearlyWorkScheduleProjectionDto('ExistingResourceId', 2028));

        $this->assertCount(260, $projection->getDates());
    }
}
