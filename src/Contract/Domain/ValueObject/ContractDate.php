<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Domain\ValueObject;

use DateTimeImmutable;

final readonly class ContractDate
{
    private DateTimeImmutable $value;

    public function __construct(string $value)
    {
        $this->value = new DateTimeImmutable($value);
    }

    public function isAfter(ContractDate $endDate): bool
    {
        return $this->value > $endDate->value;
    }

    public function unwrap(): DateTimeImmutable
    {
        return $this->value;
    }
}
