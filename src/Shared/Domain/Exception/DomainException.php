<?php

declare(strict_types=1);

namespace JDevelop\Erp\Shared\Domain\Exception;

abstract class DomainException extends \DomainException
{
    abstract public function getErrorKey(): string;
}
