<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\Entity;

use JDevelop\Erp\Availability\Domain\ValueObject\WorkScheduleConfiguration;

final readonly class WorkSchedule
{
    public function __construct(private Resource $resource, private WorkScheduleConfiguration $configuration)
    {
    }

    public function getResource(): Resource
    {
        return $this->resource;
    }

    public function getConfiguration(): WorkScheduleConfiguration
    {
        return $this->configuration;
    }
}
