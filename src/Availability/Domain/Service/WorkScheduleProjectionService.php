<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\Service;

use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use JDevelop\Erp\Availability\Domain\Entity\PublicHoliday;
use JDevelop\Erp\Availability\Domain\Repository\PublicHolidayRepositoryInterface;
use JDevelop\Erp\Availability\Domain\ValueObject\WorkDay;

final readonly class WorkScheduleProjectionService
{
    public function __construct(private PublicHolidayRepositoryInterface $publicHolidayRepository)
    {
    }

    /**
     * @param iterable<WorkDay> $workingDays
     * @return iterable<DateTimeImmutable>
     */
    public function project(
        DateTimeImmutable $startDate,
        DateTimeImmutable $endDate,
        iterable $workingDays,
        bool $includePublicHolidays = true
    ): iterable {
        $publicHolidays = $includePublicHolidays
            ? array_map(
                fn(PublicHoliday $publicHoliday) => $publicHoliday->getDate()->format('Y-m-d'),
                iterator_to_array($this->publicHolidayRepository->findAllBetweenTwoDates($startDate, $endDate))
            )
            : [];

        $interval = new DateInterval('P1D');
        $period = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

        $workableDays = [];
        foreach ($period as $date) {
            if (in_array($date->format('Y-m-d'), $publicHolidays, true)) {
                continue;
            }
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
