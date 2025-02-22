<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Application\GetMonthlyWorkScheduleProjection;

use DateTimeImmutable;

final readonly class MonthlyWorkScheduleProjectionDto
{
    /**
     * @param iterable<DateTimeImmutable> $dates
     */
    public function __construct(private iterable $dates)
    {
    }

    /**
     * @return iterable<DateTimeImmutable>
     */
    public function getDates(): iterable
    {
        return $this->dates;
    }
}
