<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Application\GetYearlyWorkScheduleProjection;

use DateTimeImmutable;

final readonly class YearlyWorkScheduleProjectionDto
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
