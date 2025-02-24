<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Domain\Entity;

final readonly class Customer
{
    public function __construct(private string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
