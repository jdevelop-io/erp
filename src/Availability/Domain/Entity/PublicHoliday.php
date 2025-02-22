<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\Entity;

use DateTimeImmutable;

final readonly class PublicHoliday
{
    public function __construct(private DateTimeImmutable $date, private string $label)
    {
    }

    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    public function getYear(): int
    {
        return (int)$this->date->format('Y');
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
