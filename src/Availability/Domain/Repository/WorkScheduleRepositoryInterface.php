<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\Repository;

use JDevelop\Erp\Availability\Domain\Entity\WorkSchedule;

interface WorkScheduleRepositoryInterface
{
    public function save(WorkSchedule $workSchedule): void;

    public function findByResourceId(string $resourceId): ?WorkSchedule;
}
