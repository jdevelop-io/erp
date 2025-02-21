<?php

declare(strict_types=1);

namespace JDevelop\Erp\Tests\Company\Builder;

use JDevelop\Erp\Company\Domain\Entity\Company;
use JDevelop\Erp\Company\Domain\ValueObject\RegistrationNumber;
use JDevelop\Erp\Company\Domain\ValueObject\Siren;

final readonly class CompanyBuilder
{
    private RegistrationNumber $registrationNumber;
    private string $name;

    public function withRegistrationNumber(string $registrationNumber): self
    {
        $this->registrationNumber = new Siren($registrationNumber);

        return $this;
    }

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function build(): Company
    {
        return new Company(
            $this->registrationNumber,
            $this->name
        );
    }
}
