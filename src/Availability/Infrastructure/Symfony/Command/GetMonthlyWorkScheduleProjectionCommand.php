<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Infrastructure\Symfony\Command;

use DateTimeImmutable;
use JDevelop\Erp\Availability\Application\GetMonthlyWorkScheduleProjection\GetMonthlyWorkScheduleProjectionDto;
use JDevelop\Erp\Availability\Application\GetMonthlyWorkScheduleProjection\GetMonthlyWorkScheduleProjectionService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'availability:work-schedule:projection:month',
    description: 'Get monthly work schedule projection'
)]
final class GetMonthlyWorkScheduleProjectionCommand extends Command
{
    private const string OPTION_RESOURCE_ID = 'resource-id';
    private const string OPTION_MONTH = 'month';

    public function __construct(
        private readonly GetMonthlyWorkScheduleProjectionService $getMonthlyWorkScheduleProjectionService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(self::OPTION_RESOURCE_ID, null, InputOption::VALUE_REQUIRED, 'Resource id');
        $this->addOption(self::OPTION_MONTH, null, InputOption::VALUE_REQUIRED, 'Month');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $resourceId = $input->getOption(self::OPTION_RESOURCE_ID);
        $month = $input->getOption(self::OPTION_MONTH);

        $monthlyWorkScheduleProjection = $this->getMonthlyWorkScheduleProjectionService->execute(
            new GetMonthlyWorkScheduleProjectionDto($resourceId, $month)
        );

        $io->title(sprintf("Monthly work schedule projection for resource %s and month %s", $resourceId, $month));

        $io->table(
            ['Week number', 'Week Day', 'Date'],
            array_map(
                fn(DateTimeImmutable $date) => [
                    $date->format('W'),
                    mb_ucfirst($date->format('l')),
                    $date->format('Y-m-d')
                ],
                $monthlyWorkScheduleProjection->getDates()
            )
        );

        $io->success(
            sprintf(
                "Monthly work schedule projection with %s dates generated successfully!",
                count($monthlyWorkScheduleProjection->getDates())
            )
        );

        return Command::SUCCESS;
    }
}
