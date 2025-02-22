<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Application\GetMonthlyWorkScheduleProjection;

final readonly class GetMonthlyWorkScheduleProjectionDto
{
    public function __construct(private string $resourceId, private string $month)
    {
    }

    public function getResourceId(): string
    {
        return $this->resourceId;
    }

    public function getMonth(): string
    {
        return $this->month;
    }
}
