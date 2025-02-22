<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Application\GetYearlyWorkScheduleProjection;

use DateTimeImmutable;
use JDevelop\Erp\Availability\Domain\Exception\ResourceNotFoundException;
use JDevelop\Erp\Availability\Domain\Exception\WorkScheduleNotFoundException;
use JDevelop\Erp\Availability\Domain\Repository\ResourceRepositoryInterface;
use JDevelop\Erp\Availability\Domain\Repository\WorkScheduleRepositoryInterface;
use JDevelop\Erp\Availability\Domain\Service\WorkScheduleProjectionService;

final readonly class GetYearlyWorkScheduleProjectionService
{
    public function __construct(
        private ResourceRepositoryInterface $resourceRepository,
        private WorkScheduleRepositoryInterface $workScheduleRepository,
        private WorkScheduleProjectionService $workScheduleProjectionService
    ) {
    }

    public function execute(GetYearlyWorkScheduleProjectionDto $getYearlyWorkScheduleProjectionDto
    ): YearlyWorkScheduleProjectionDto {
        $resource = $this->resourceRepository->findById($getYearlyWorkScheduleProjectionDto->getResourceId());
        if ($resource === null) {
            throw new ResourceNotFoundException($getYearlyWorkScheduleProjectionDto->getResourceId());
        }

        $workSchedule = $this->workScheduleRepository->findByResourceId(
            $getYearlyWorkScheduleProjectionDto->getResourceId()
        );
        if ($workSchedule === null) {
            throw new WorkScheduleNotFoundException($getYearlyWorkScheduleProjectionDto->getResourceId());
        }

        $workingDays = $workSchedule->getConfiguration()->getWorkingDays();
        $startDate = new DateTimeImmutable($getYearlyWorkScheduleProjectionDto->getYear() . '-01-01');
        $endDate = new DateTimeImmutable($getYearlyWorkScheduleProjectionDto->getYear() . '-12-31');
        $yearlyWorkScheduleProjectionDates = $this->workScheduleProjectionService->project(
            $startDate,
            $endDate,
            $workingDays,
        );

        return new YearlyWorkScheduleProjectionDto(
            $yearlyWorkScheduleProjectionDates
        );
    }
}
