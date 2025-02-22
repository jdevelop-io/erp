<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Infrastructure\Symfony\Command;

use DateTimeImmutable;
use JDevelop\Erp\Availability\Application\GetYearlyWorkScheduleProjection\GetYearlyWorkScheduleProjectionDto;
use JDevelop\Erp\Availability\Application\GetYearlyWorkScheduleProjection\GetYearlyWorkScheduleProjectionService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'availability:projection:year',
    description: 'Get yearly work schedule projection'
)]
final class GetYearlyWorkScheduleProjectionCommand extends Command
{
    private const string OPTION_RESOURCE_ID = 'resource-id';
    private const string OPTION_YEAR = 'year';

    public function __construct(
        private readonly GetYearlyWorkScheduleProjectionService $getYearlyWorkScheduleProjectionService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(self::OPTION_RESOURCE_ID, null, InputOption::VALUE_REQUIRED, 'Resource id');
        $this->addOption(self::OPTION_YEAR, null, InputOption::VALUE_REQUIRED, 'Year');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $resourceId = $input->getOption(self::OPTION_RESOURCE_ID);
        $year = (int)$input->getOption(self::OPTION_YEAR);

        $yearlyWorkScheduleProjection = $this->getYearlyWorkScheduleProjectionService->execute(
            new GetYearlyWorkScheduleProjectionDto($resourceId, $year)
        );

        $io->title(sprintf("Yearly work schedule projection for resource %s and year %d", $resourceId, $year));

        $io->table(
            ['Week number', 'Week Day', 'Date'],
            array_map(
                fn(DateTimeImmutable $date) => [
                    $date->format('W'),
                    mb_ucfirst($date->format('l')),
                    $date->format('Y-m-d')
                ],
                $yearlyWorkScheduleProjection->getDates()
            )
        );

        $io->success(
            sprintf(
                "Yearly work schedule projection with %s dates generated successfully!",
                count($yearlyWorkScheduleProjection->getDates())
            )
        );

        return Command::SUCCESS;
    }
}
