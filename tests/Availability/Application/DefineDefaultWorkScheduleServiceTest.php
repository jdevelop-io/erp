<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Availability\Application;

use JDevelop\Erp\Availability\Application\DefineDefaultWorkSchedule\DefineDefaultWorkScheduleDto;
use JDevelop\Erp\Availability\Application\DefineDefaultWorkSchedule\DefineDefaultWorkScheduleService;
use JDevelop\Erp\Availability\Domain\Exception\InvalidWorkScheduleException;
use JDevelop\Erp\Availability\Domain\Exception\ResourceNotFoundException;
use JDevelop\Erp\Tests\Availability\WorkScheduleTest;

final class DefineDefaultWorkScheduleServiceTest extends WorkScheduleTest
{
    private readonly DefineDefaultWorkScheduleService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new DefineDefaultWorkScheduleService($this->resourceRepository, $this->workScheduleRepository);

        $this->createResource('ExistingResourceId');
    }

    public function testResourceShouldExists(): void
    {
        $this->expectException(ResourceNotFoundException::class);

        $this->service->execute(
            new DefineDefaultWorkScheduleDto(
                'InvalidResourceId', [
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
                ]
            )
        );
    }

    public function testAllDaysShouldBeDefined(): void
    {
        $this->expectException(InvalidWorkScheduleException::class);

        $this->service->execute(
            new DefineDefaultWorkScheduleDto(
                'ExistingResourceId', [
                    'monday' => [
                        'type' => 'work',
                        'times' => [
                            ['start' => '09:00', 'end' => '12:30'],
                            ['start' => '14:00', 'end' => '17:00']
                        ]
                    ]
                ]
            )
        );
    }

    public function testTimesStartShouldBeBeforeEnd(): void
    {
        $this->expectException(InvalidWorkScheduleException::class);

        $this->service->execute(
            new DefineDefaultWorkScheduleDto(
                'ExistingResourceId', [
                    'monday' => [
                        'type' => 'work',
                        'times' => [
                            ['start' => '14:00', 'end' => '12:30']
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
                ]
            )
        );
    }

    public function testTimesCannotOverlap(): void
    {
        $this->expectException(InvalidWorkScheduleException::class);

        $this->service->execute(
            new DefineDefaultWorkScheduleDto(
                'ExistingResourceId', [
                    'monday' => [
                        'type' => 'work',
                        'times' => [
                            ['start' => '09:00', 'end' => '12:30'],
                            ['start' => '12:00', 'end' => '17:00']
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
                ]
            )
        );
    }

    public function testWorkScheduleShouldBeDefined(): void
    {
        $workScheduleDefinedDto = $this->service->execute(
            new DefineDefaultWorkScheduleDto(
                'ExistingResourceId', [
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
                ]
            )
        );

        $this->assertWorkScheduleShouldBeDefined($workScheduleDefinedDto->getId());
    }
}
