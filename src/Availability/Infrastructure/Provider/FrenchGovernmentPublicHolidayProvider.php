<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Infrastructure\Provider;

use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use JDevelop\Erp\Availability\Domain\Entity\PublicHoliday;
use JDevelop\Erp\Availability\Domain\Repository\PublicHolidayRepositoryInterface;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsDecorator(decorates: PublicHolidayRepositoryInterface::class)]
final readonly class FrenchGovernmentPublicHolidayProvider implements PublicHolidayRepositoryInterface
{
    public function __construct(
        private PublicHolidayRepositoryInterface $decorated,
        private HttpClientInterface $httpClient
    ) {
    }

    public function findByYear(int $year): iterable
    {
        $publicHolidays = $this->decorated->findByYear($year);
        if (!empty($publicHolidays)) {
            return $publicHolidays;
        }

        $response = $this->httpClient->request(
            'GET',
            sprintf("https://calendrier.api.gouv.fr/jours-feries/metropole/%d.json", $year)
        );

        $data = $response->toArray();

        $publicHolidays = [];
        foreach ($data as $date => $label) {
            $publicHoliday = new PublicHoliday(
                DateTimeImmutable::createFromFormat('Y-m-d', $date),
                $label
            );

            $this->save($publicHoliday);

            $publicHolidays[] = $publicHoliday;
        }

        return $publicHolidays;
    }

    public function findAllBetweenTwoDates(\DateTimeImmutable $startDate, \DateTimeImmutable $endDate): iterable
    {
        $publicHolidays = $this->decorated->findAllBetweenTwoDates($startDate, $endDate);
        if (!empty($publicHolidays)) {
            return $publicHolidays;
        }

        $interval = new DateInterval('P1Y');
        $period = new DatePeriod($startDate, $interval, $endDate->modify('+1 day'));

        $publicHolidays = [];
        foreach ($period as $date) {
            $publicHolidaysForYear = $this->findByYear((int)$date->format('Y'));

            foreach ($publicHolidaysForYear as $publicHoliday) {
                if ($publicHoliday->getDate() >= $startDate && $publicHoliday->getDate() <= $endDate) {
                    $publicHolidays[] = $publicHoliday;
                }
            }
        }

        return $publicHolidays;
    }

    public function save(PublicHoliday $publicHoliday): void
    {
        $this->decorated->save($publicHoliday);
    }
}
