<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Domain\ValueObject;

use JDevelop\Erp\Availability\Domain\Exception\InvalidTimeException;
use JDevelop\Erp\Availability\Domain\Exception\InvalidWorkScheduleException;

final readonly class WorkScheduleConfiguration
{
    /**
     * @var array<string, array>
     */
    private array $configuration;

    /**
     * @param array<string, array> $configuration
     */
    public function __construct(iterable $configuration)
    {
        $this->validate($configuration);

        $this->configuration = $configuration;
    }

    private function validate(array $configuration): void
    {
        // All days of the week should be present
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        foreach ($days as $day) {
            if (!array_key_exists($day, $configuration)) {
                throw new InvalidWorkScheduleException("Day $day is missing");
            }
        }

        // Each day should have a type and times
        $timeSlots = [];

        foreach ($configuration as $day => $dayConfiguration) {
            if (!isset($dayConfiguration['type'])) {
                throw new InvalidWorkScheduleException("Type is missing for day $day");
            }

            if (!isset($dayConfiguration['times'])) {
                throw new InvalidWorkScheduleException("Times are missing for day $day");
            }

            if (!is_array($dayConfiguration['times'])) {
                throw new InvalidWorkScheduleException("Times should be an array for day $day");
            }

            foreach ($dayConfiguration['times'] as $time) {
                if (!isset($time['start'])) {
                    throw new InvalidWorkScheduleException("Start time is missing for day $day");
                }

                if (!isset($time['end'])) {
                    throw new InvalidWorkScheduleException("End time is missing for day $day");
                }

                if (!is_string($time['start'])) {
                    throw new InvalidWorkScheduleException("Start time should be a string for day $day");
                }

                if (!is_string($time['end'])) {
                    throw new InvalidWorkScheduleException("End time should be a string for day $day");
                }

                try {
                    $start = new Time($time['start']);
                } catch (InvalidTimeException $e) {
                    throw new InvalidWorkScheduleException("Invalid start time for day $day: " . $e->getMessage());
                }

                try {
                    $end = new Time($time['end']);
                } catch (InvalidTimeException $e) {
                    throw new InvalidWorkScheduleException("Invalid end time for day $day: " . $e->getMessage());
                }

                if ($start->isAfter($end)) {
                    throw new InvalidWorkScheduleException("Start time should be before end time for day $day");
                }

                $timeSlots[] = new TimeSlot($start, $end);
            }

            if (!in_array($dayConfiguration['type'], ['work', 'off'], true)) {
                throw new InvalidWorkScheduleException("Invalid type for day $day");
            }

            if ($dayConfiguration['type'] === 'off' && !empty($dayConfiguration['times'])) {
                throw new InvalidWorkScheduleException("Off day should not have times for day $day");
            }

            if ($dayConfiguration['type'] === 'work' && empty($dayConfiguration['times'])) {
                throw new InvalidWorkScheduleException("Work day should have times for day $day");
            }
        }

        // Times should not overlap
        foreach ($timeSlots as $timeSlot) {
            foreach ($timeSlots as $otherTimeSlot) {
                if ($timeSlot === $otherTimeSlot) {
                    continue;
                }

                if ($timeSlot->overlaps($otherTimeSlot)) {
                    throw new InvalidWorkScheduleException("Time slots should not overlap");
                }
            }
        }
    }

    /**
     * @return array<string, array>
     */
    public function toArray(): array
    {
        return $this->configuration;
    }

    /**
     * @return iterable<WorkDay>
     */
    public function getWorkingDays(): iterable
    {
        return array_map(
            fn(string $day) => WorkDay::from($day),
            array_keys(
                array_filter(
                    $this->configuration,
                    fn(array $dayConfiguration) => $dayConfiguration['type'] === 'work'
                )
            )
        );
    }
}
