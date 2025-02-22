<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\Exception;

use Exception;

final class WorkScheduleNotFoundException extends Exception
{
    public function __construct(string $workScheduleId)
    {
        parent::__construct(sprintf('Work schedule with id <%s> not found', $workScheduleId));
    }
}
