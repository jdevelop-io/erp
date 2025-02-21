<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Application\DefineDefaultWorkSchedule;

use JDevelop\Erp\Availability\Domain\Entity\WorkSchedule;
use JDevelop\Erp\Availability\Domain\Exception\ResourceNotFoundException;
use JDevelop\Erp\Availability\Domain\Repository\ResourceRepositoryInterface;
use JDevelop\Erp\Availability\Domain\Repository\WorkScheduleRepositoryInterface;
use JDevelop\Erp\Availability\Domain\ValueObject\WorkScheduleConfiguration;

final readonly class DefineDefaultWorkScheduleService
{
    public function __construct(
        private ResourceRepositoryInterface $resourceRepository,
        private WorkScheduleRepositoryInterface $workScheduleRepository
    ) {
    }

    public function execute(DefineDefaultWorkScheduleDto $defineDefaultWorkScheduleDto): WorkScheduleDefinedDto
    {
        $resource = $this->resourceRepository->findById($defineDefaultWorkScheduleDto->getResourceId());
        if ($resource === null) {
            throw new ResourceNotFoundException($defineDefaultWorkScheduleDto->getResourceId());
        }

        $configuration = new WorkScheduleConfiguration($defineDefaultWorkScheduleDto->getConfiguration());
        $workSchedule = new WorkSchedule($resource, $configuration);
        $this->workScheduleRepository->save($workSchedule);

        return new WorkScheduleDefinedDto($workSchedule->getResource()->getId());
    }
}
