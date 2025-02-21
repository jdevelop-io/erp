<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Application\DefineDefaultWorkSchedule;

final readonly class WorkScheduleDefinedDto
{
    public function __construct(private string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
