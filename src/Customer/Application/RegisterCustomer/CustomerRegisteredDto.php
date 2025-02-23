<?php

declare(strict_types=1);

namespace JDevelop\Erp\Customer\Application\RegisterCustomer;

final readonly class CustomerRegisteredDto
{
    public function __construct(private string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
