<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Availability\Builder;

use JDevelop\Erp\Availability\Domain\Entity\Resource;
use JDevelop\Erp\Availability\Domain\Entity\WorkSchedule;
use JDevelop\Erp\Availability\Domain\ValueObject\WorkScheduleConfiguration;

final readonly class WorkScheduleBuilder
{
    private Resource $resource;
    private WorkScheduleConfiguration $configuration;

    public function withResource(Resource $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    public function withConfiguration(array $configuration): self
    {
        $this->configuration = new WorkScheduleConfiguration($configuration);

        return $this;
    }

    public function build(): WorkSchedule
    {
        return new WorkSchedule($this->resource, $this->configuration);
    }
}
