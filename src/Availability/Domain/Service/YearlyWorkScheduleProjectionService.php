<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\Service;

use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use JDevelop\Erp\Availability\Domain\ValueObject\WorkDay;

final readonly class YearlyWorkScheduleProjectionService
{

    /**
     * @param iterable<WorkDay> $workingDays
     * @return iterable<DateTimeImmutable>
     */
    public function project(iterable $workingDays, int $year): iterable
    {
        $startDate = new DateTimeImmutable("$year-01-01");
        $endDate = new DateTimeImmutable("$year-12-31");
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

        $workableDays = [];
        foreach ($period as $date) {
            $day = mb_strtolower($date->format('l'));
            if (in_array(
                $day,
                array_map(fn(WorkDay $workDay) => $workDay->value, iterator_to_array($workingDays))
            )) {
                $workableDays[] = $date;
            }
        }
        return $workableDays;
    }
}
