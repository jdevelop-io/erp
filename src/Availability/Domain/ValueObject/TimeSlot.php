<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\ValueObject;

final readonly class TimeSlot
{
    public function __construct(private Time $start, private Time $end)
    {
    }

    public function overlaps(TimeSlot $timeSlot): bool
    {
        return $this->start->isAfter($timeSlot->start) && $this->start->isBefore($timeSlot->end)
            || $this->end->isAfter($timeSlot->start) && $this->end->isBefore($timeSlot->end);
    }
}
