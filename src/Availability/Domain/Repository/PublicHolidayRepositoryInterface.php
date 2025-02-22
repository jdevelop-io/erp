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
}
