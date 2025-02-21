<?php

declare(strict_types=1);

namespace JDevelop\Erp\Resource\Application\RegisterResource;

final readonly class ResourceRegisteredDto
{
    public function __construct(private string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
