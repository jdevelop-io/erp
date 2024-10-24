<?php

declare(strict_types=1);

namespace JDevelop\Erp\Company\Domain\ValueObject;

use JDevelop\Erp\Company\Domain\Exception\InvalidRegistrationNumberException;

final class Siren extends RegistrationNumber
{
    public static function of(string $value): self
    {
        return new self($value);
    }

    protected function validate(string $value): void
    {
        parent::validate($value);

        if (!preg_match('/^\d{9}$/', $value)) {
            throw new InvalidRegistrationNumberException($value);
        }

        $this->validateUsingLuhnAlgorithm($value);
    }

    private function validateUsingLuhnAlgorithm(string $value): void
    {
        $sum = 0;
        $length = strlen($value);

        for ($i = 0; $i < $length; $i++) {
            $digit = (int)$value[$length - $i - 1];

            if ($i % 2 === 1) {
                $digit *= 2;
                if ($digit > 9) {
                    $digit -= 9;
                }
            }

            $sum += $digit;
        }

        if ($sum % 10 !== 0) {
            throw new InvalidRegistrationNumberException($value);
        }
    }
}
