<?php

declare(strict_types=1);

namespace JDevelop\Erp\Contract\Domain\Exception;

use Exception;
use JDevelop\Erp\Contract\Domain\ValueObject\ContractDate;

final class InvalidDatesSequenceException extends Exception
{
    public function __construct(ContractDate $beginDate, ContractDate $endDate)
    {
        parent::__construct(
            sprintf(
                'Invalid dates sequence: begin date <%s> is after end date <%s>',
                $beginDate->unwrap()->format('Y-m-d'),
                $endDate->unwrap()->format('Y-m-d')
            )
        );
    }
}
