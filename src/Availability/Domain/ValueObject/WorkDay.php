<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\ValueObject;

enum WorkDay: string
{
    case MONDAY = 'monday';
    case TUESDAY = 'tuesday';
    case WEDNESDAY = 'wednesday';
    case THURSDAY = 'thursday';
    case FRIDAY = 'friday';
    case SATURDAY = 'saturday';
    case SUNDAY = 'sunday';
}
