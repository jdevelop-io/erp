<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\ValueObject;

use DateTimeImmutable;
use JDevelop\Erp\Availability\Domain\Exception\InvalidTimeException;

final readonly class Time
{
    private DateTimeImmutable $value;

    public function __construct(string $value)
    {
        $this->validate($value);

        $this->value = DateTimeImmutable::createFromFormat('H:i', $value)
            ?? throw new InvalidTimeException("Invalid time format: $value");
    }

    private function validate(string $value): void
    {
        if (!preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $value)) {
            throw new InvalidTimeException("Invalid time format: $value");
        }
    }

    public function isAfter(Time $end): bool
    {
        return $this->value > $end->value;
    }

    public function isBefore(Time $end): bool
    {
        return $this->value < $end->value;
    }
}
