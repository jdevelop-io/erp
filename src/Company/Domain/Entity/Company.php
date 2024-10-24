<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\Entity;

use JDevelop\Erp\Company\Domain\ValueObject\CountryCode;
use JDevelop\Erp\Company\Domain\ValueObject\RegistrationNumber;

final readonly class Company
{
    private function __construct(private RegistrationNumber $registrationNumber, private CountryCode $countryCode)
    {
    }

    public static function register(RegistrationNumber $registrationNumber, CountryCode $countryCode): self
    {
        return new self($registrationNumber, $countryCode);
    }

    public function getRegistrationNumber(): RegistrationNumber
    {
        return $this->registrationNumber;
    }

    public function getCountryCode(): CountryCode
    {
        return $this->countryCode;
    }
}
