<?php

declare(strict_types=1);

namespace JDevelop\Erp\Commitment\Domain\Exception;

use Exception;
use JDevelop\Erp\Commitment\Domain\ValueObject\CommitmentDate;

final class InvalidDatesSequenceException extends Exception
{
    public function __construct(CommitmentDate $beginDate, CommitmentDate $endDate)
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
