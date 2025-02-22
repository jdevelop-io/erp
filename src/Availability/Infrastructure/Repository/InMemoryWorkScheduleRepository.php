<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Infrastructure\Repository;

use JDevelop\Erp\Availability\Domain\Entity\WorkSchedule;
use JDevelop\Erp\Availability\Domain\Repository\WorkScheduleRepositoryInterface;

final class InMemoryWorkScheduleRepository implements WorkScheduleRepositoryInterface
{
    /**
     * @var array<string, WorkSchedule>
     */
    private iterable $workScheduleById = [];

    public function save(WorkSchedule $workSchedule): void
    {
        $this->workScheduleById[$workSchedule->getResource()->getId()] = $workSchedule;
    }

    public function findByResourceId(string $id): ?WorkSchedule
    {
        return $this->workScheduleById[$id] ?? null;
    }
}
