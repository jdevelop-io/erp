<?php

declare(strict_types=1);

namespace JDevelop\Erp\Availability\Infrastructure\Symfony\Command;

use JDevelop\Erp\Availability\Application\DefineDefaultWorkSchedule\DefineDefaultWorkScheduleDto;
use JDevelop\Erp\Availability\Application\DefineDefaultWorkSchedule\DefineDefaultWorkScheduleService;
use JDevelop\Erp\Availability\Domain\Repository\WorkScheduleRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'availability:work-schedule:define',
    description: 'Define a default work schedule for a resource'
)]
final class DefineDefaultWorkScheduleCommand extends Command
{
    public function __construct(
        private readonly WorkScheduleRepositoryInterface $workScheduleRepository,
        private readonly DefineDefaultWorkScheduleService $defineDefaultWorkScheduleService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('resource-id', null, InputOption::VALUE_REQUIRED, 'Resource ID');
        $this->addOption('configuration', null, InputOption::VALUE_REQUIRED, 'Work schedule configuration');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $resourceId = $input->getOption('resource-id');
        $configuration = json_decode($input->getOption('configuration'), true);

        $workScheduleDefinedDto = $this->defineDefaultWorkScheduleService->execute(
            new DefineDefaultWorkScheduleDto($resourceId, $configuration)
        );
        $workSchedule = $this->workScheduleRepository->findByResourceId($workScheduleDefinedDto->getId());

        $io->table(
            ['Resource ID', 'Configuration'],
            [
                [
                    $workSchedule->getResource()->getId(),
                    json_encode($workSchedule->getConfiguration()->toArray(), JSON_PRETTY_PRINT)
                ]
            ]
        );

        $io->success('Work schedule defined successfully!');

        return Command::SUCCESS;
    }
}
