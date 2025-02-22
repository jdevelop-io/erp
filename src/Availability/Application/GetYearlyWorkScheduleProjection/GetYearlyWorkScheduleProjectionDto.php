<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Application\GetYearlyWorkScheduleProjection;

final readonly class GetYearlyWorkScheduleProjectionDto
{
    public function __construct(private string $resourceId, private int $year)
    {
    }

    public function getResourceId(): string
    {
        return $this->resourceId;
    }

    public function getYear(): int
    {
        return $this->year;
    }
}
