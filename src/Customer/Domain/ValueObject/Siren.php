<?php

declare(strict_types=1);

namespace JDevelop\Erp\Customer\Domain\ValueObject;

use JDevelop\Erp\Customer\Domain\Exception\InvalidRegistrationNumberException;

final readonly class Siren extends RegistrationNumber
{
    public function __construct(string $value)
    {
        $this->validate($value);

        parent::__construct($value);
    }

    private function validate(string $value): void
    {
        if (!preg_match('/^\d{9}$/', $value)) {
            throw new InvalidRegistrationNumberException($value);
        }
    }
}
