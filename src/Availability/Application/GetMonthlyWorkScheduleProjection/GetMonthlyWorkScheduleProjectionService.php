<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Application\GetMonthlyWorkScheduleProjection;

use DateTimeImmutable;
use JDevelop\Erp\Availability\Domain\Exception\ResourceNotFoundException;
use JDevelop\Erp\Availability\Domain\Exception\WorkScheduleNotFoundException;
use JDevelop\Erp\Availability\Domain\Repository\ResourceRepositoryInterface;
use JDevelop\Erp\Availability\Domain\Repository\WorkScheduleRepositoryInterface;
use JDevelop\Erp\Availability\Domain\Service\WorkScheduleProjectionService;

final readonly class GetMonthlyWorkScheduleProjectionService
{
    public function __construct(
        private ResourceRepositoryInterface $resourceRepository,
        private WorkScheduleRepositoryInterface $workScheduleRepository,
        private WorkScheduleProjectionService $monthlyWorkScheduleProjectionService
    ) {
    }

    public function execute(
        GetMonthlyWorkScheduleProjectionDto $getMonthlyWorkScheduleProjectDto
    ): MonthlyWorkScheduleProjectionDto {
        $resource = $this->resourceRepository->findById($getMonthlyWorkScheduleProjectDto->getResourceId());
        if ($resource === null) {
            throw new ResourceNotFoundException($getMonthlyWorkScheduleProjectDto->getResourceId());
        }

        $workSchedule = $this->workScheduleRepository->findByResourceId(
            $getMonthlyWorkScheduleProjectDto->getResourceId()
        );
        if ($workSchedule === null) {
            throw new WorkScheduleNotFoundException($getMonthlyWorkScheduleProjectDto->getResourceId());
        }

        $workingDays = $workSchedule->getConfiguration()->getWorkingDays();
        $startDate = new DateTimeImmutable($getMonthlyWorkScheduleProjectDto->getMonth() . '-01');
        $endDate = $startDate->modify('last day of this month');
        $monthlyWorkScheduleProjectionDates = $this->monthlyWorkScheduleProjectionService->project(
            $startDate,
            $endDate,
            $workingDays,
        );

        return new MonthlyWorkScheduleProjectionDto(
            $monthlyWorkScheduleProjectionDates
        );
    }
}
