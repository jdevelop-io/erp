<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\Repository;

use JDevelop\Erp\Availability\Domain\Entity\PublicHoliday;

interface PublicHolidayRepositoryInterface
{
    /**
     * @return iterable<PublicHoliday>
     */
    public function findByYear(int $year): iterable;

    /**
     * @return iterable<PublicHoliday>
     */
    public function findAllBetweenTwoDates(\DateTimeImmutable $startDate, \DateTimeImmutable $endDate): iterable;

    public function save(PublicHoliday $publicHoliday): void;
}
