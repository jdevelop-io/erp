<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Application\DefineDefaultWorkSchedule;

final readonly class DefineDefaultWorkScheduleDto
{
    /**
     * @param string $resourceId
     * @param array<string, array> $configuration
     */
    public function __construct(private string $resourceId, private iterable $configuration)
    {
    }

    public function getResourceId(): string
    {
        return $this->resourceId;
    }

    public function getConfiguration(): iterable
    {
        return $this->configuration;
    }
}
