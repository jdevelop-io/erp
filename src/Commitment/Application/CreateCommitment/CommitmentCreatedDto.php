<?php

declare(strict_types=1);

namespace JDevelop\Erp\Commitment\Application\CreateCommitment;

final readonly class CommitmentCreatedDto
{
    public function __construct(private string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
