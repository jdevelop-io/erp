<?php

declare(strict_types=1);

namespace JDevelop\Erp\Commitment\Domain\ValueObject;

use DateTimeImmutable;

final readonly class CommitmentDate
{
    private DateTimeImmutable $value;

    public function __construct(string $value)
    {
        $this->value = new DateTimeImmutable($value);
    }

    public function isAfter(CommitmentDate $endDate): bool
    {
        return $this->value > $endDate->value;
    }

    public function unwrap(): DateTimeImmutable
    {
        return $this->value;
    }
}
