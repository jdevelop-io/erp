<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\Exception;

use Exception;

final class InvalidWorkScheduleException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
