<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Infrastructure\Repository;

use JDevelop\Erp\Availability\Domain\Entity\PublicHoliday;
use JDevelop\Erp\Availability\Domain\Repository\PublicHolidayRepositoryInterface;

final class InMemoryPublicHolidayRepository implements PublicHolidayRepositoryInterface
{
    /**
     * @var array<PublicHoliday>
     */
    private iterable $publicHolidayByYear = [];

    public function save(PublicHoliday $publicHoliday): void
    {
        $this->publicHolidayByYear[$publicHoliday->getYear()][] = $publicHoliday;
    }

    /**
     * @return array<PublicHoliday>
     */
    public function findByYear(int $year): iterable
    {
        return $this->publicHolidayByYear[$year] ?? [];
    }

    public function findAllBetweenTwoDates(\DateTimeImmutable $startDate, \DateTimeImmutable $endDate): iterable
    {
        $publicHolidays = [];
        foreach ($this->publicHolidayByYear as $publicHolidaysByYear) {
            foreach ($publicHolidaysByYear as $publicHoliday) {
                if ($publicHoliday->getDate() >= $startDate && $publicHoliday->getDate() <= $endDate) {
                    $publicHolidays[] = $publicHoliday;
                }
            }
        }
        return $publicHolidays;
    }
}
