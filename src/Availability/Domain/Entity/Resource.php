<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\Entity;

final readonly class Resource
{
    public function __construct(private string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
