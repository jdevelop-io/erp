<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\Entity;

use JDevelop\Erp\Company\Domain\ValueObject\RegistrationNumber;

final readonly class Company
{
    public function __construct(private RegistrationNumber $registrationNumber, private string $name)
    {
    }

    public function getRegistrationNumber(): RegistrationNumber
    {
        return $this->registrationNumber;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
