<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Application\CreateContract;

final readonly class ContractCreatedDto
{
    public function __construct(private string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
