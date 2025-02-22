<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Availability\Builder;

use DateTimeImmutable;
use JDevelop\Erp\Availability\Domain\Entity\PublicHoliday;

final class PublicHolidayBuilder
{
    private DateTimeImmutable $date;
    private string $label;

    public function withDate(string $date): self
    {
        $this->date = DateTimeImmutable::createFromFormat('Y-m-d', $date)
            ?? throw new \InvalidArgumentException("Invalid date format: $date");

        $this->date = $this->date->setTime(0, 0);

        return $this;
    }

    public function withLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function build(): PublicHoliday
    {
        return new PublicHoliday($this->date, $this->label);
    }
}
