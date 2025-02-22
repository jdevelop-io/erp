<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Availability\Application;

use JDevelop\Erp\Availability\Application\GetMonthlyWorkScheduleProjection\GetMonthlyWorkScheduleProjectDto;
use JDevelop\Erp\Availability\Application\GetMonthlyWorkScheduleProjection\GetMonthlyWorkScheduleProjectionService;
use JDevelop\Erp\Availability\Domain\Exception\ResourceNotFoundException;
use JDevelop\Erp\Availability\Domain\Exception\WorkScheduleNotFoundException;
use JDevelop\Erp\Availability\Domain\Service\WorkScheduleProjectionService;
use JDevelop\Erp\Tests\Availability\WorkScheduleTest;

final class GetMonthlyWorkScheduleProjectServiceTest extends WorkScheduleTest
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

    private readonly WorkScheduleProjectionService $monthlyWorkScheduleProjectionService;
    private readonly GetMonthlyWorkScheduleProjectionService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->monthlyWorkScheduleProjectionService = new WorkScheduleProjectionService(
            $this->publicHolidayRepository
        );
        $this->service = new GetMonthlyWorkScheduleProjectionService(
            $this->resourceRepository,
            $this->workScheduleRepository,
            $this->monthlyWorkScheduleProjectionService
        );

        $this->createResource('ExistingResourceIdWithoutWorkSchedule');

        $this->createResource('ExistingResourceId');
        $this->createWorkSchedule('ExistingResourceId', self::WORK_SCHEDULE);
    }

    public function testResourceShouldExists(): void
    {
        $this->expectException(ResourceNotFoundException::class);

        $this->service->execute(new GetMonthlyWorkScheduleProjectDto('InvalidResourceId', '2025-03'));
    }

    public function testWorkScheduleShouldExists(): void
    {
        $this->expectException(WorkScheduleNotFoundException::class);

        $this->service->execute(
            new GetMonthlyWorkScheduleProjectDto('ExistingResourceIdWithoutWorkSchedule', '2025-03')
        );
    }

    public function testProjectionFor2025MarchShouldBe21(): void
    {
        $projection = $this->service->execute(new GetMonthlyWorkScheduleProjectDto('ExistingResourceId', '2025-03'));

        $this->assertCount(21, $projection->getDates());
    }

    public function testProjectionFor2025MayShouldBe23(): void
    {
        $this->createPublicHoliday('2025-05-01', 'Labor Day');
        $this->createPublicHoliday('2025-05-08', 'Victory Day');
        $this->createPublicHoliday('2025-05-25', "Mother's Day");
        $this->createPublicHoliday('2025-05-29', 'Ascension Day');

        $projection = $this->service->execute(new GetMonthlyWorkScheduleProjectDto('ExistingResourceId', '2025-05'));

        $this->assertCount(19, $projection->getDates());
    }
}
