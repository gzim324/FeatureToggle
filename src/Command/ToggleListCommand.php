<?php

namespace FeatureToggle\Command;

use FeatureToggle\FeatureManager;
use FeatureToggle\FeatureToggle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * FeatureToggle.
 *
 * @author Michal Zimka <michal.zimka@gmail.com>
 */
#[AsCommand(
    name: 'toggle:list',
    description: 'List of toggles',
)]
class ToggleListCommand extends Command
{
    public function __construct(
        private readonly FeatureManager $featureManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            'active',
            null,
            InputOption::VALUE_OPTIONAL,
            'Filter toggles by active status (true/1 for active, false/0 for inactive)',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $toggles = $this->getToggles($input);

        if (empty($toggles)) {
            $io->warning('No feature toggles found.');

            return Command::SUCCESS;
        }

        $this->displayToggles($io, $toggles);

        return Command::SUCCESS;
    }

    private function getToggles(InputInterface $input): array
    {
        $activeFilter = $input->getOption('active');
        $toggles = $this->featureManager->listToggles();

        if ($activeFilter !== null) {
            $isActive = filter_var($activeFilter, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

            return array_filter(
                $toggles,
                fn(FeatureToggle $toggle) => $isActive === null || $toggle->isActive() === $isActive,
            );
        }

        return $toggles;
    }

    private function displayToggles(SymfonyStyle $io, array $toggles): void
    {
        $io->table(
            ['Name', 'Status'],
            array_map(
                fn(FeatureToggle $toggle)
                    => [
                    $toggle->getName(),
                    $toggle->isActive() ? 'ACTIVE' : 'INACTIVE',
                ],
                $toggles,
            ),
        );
    }
}
