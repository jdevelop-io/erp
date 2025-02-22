<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Infrastructure\Repository;

use Doctrine\DBAL\Connection;
use JDevelop\Erp\Availability\Domain\Entity\Resource;
use JDevelop\Erp\Availability\Domain\Entity\WorkSchedule;
use JDevelop\Erp\Availability\Domain\Repository\WorkScheduleRepositoryInterface;
use JDevelop\Erp\Availability\Domain\ValueObject\WorkScheduleConfiguration;

final readonly class DoctrineWorkScheduleRepository implements WorkScheduleRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function save(WorkSchedule $workSchedule): void
    {
        $affectedRows = $this->connection->createQueryBuilder()
            ->insert('availability_work_schedule')
            ->values([
                'resource_id' => ':resource_id',
                'configuration' => ':configuration',
            ])
            ->setParameters([
                'resource_id' => $workSchedule->getResource()->getId(),
                'configuration' => json_encode($workSchedule->getConfiguration()->toArray()),
            ])
            ->executeStatement();

        if ($affectedRows !== 1) {
            throw new \RuntimeException('Work schedule could not be saved');
        }
    }

    public function findByResourceId(string $resourceId): ?WorkSchedule
    {
        $result = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('availability_work_schedule')
            ->where('resource_id = :resource_id')
            ->setParameter('resource_id', $resourceId)
            ->executeQuery();

        $data = $result->fetchAssociative();

        if ($data === false) {
            return null;
        }

        return new WorkSchedule(
            new Resource((string)$data['resource_id']),
            new WorkScheduleConfiguration(json_decode($data['configuration'], true)),
        );
    }
}
