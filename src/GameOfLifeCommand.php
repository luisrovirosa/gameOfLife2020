<?php

declare(strict_types = 1);

namespace Katas;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GameOfLifeCommand extends Command
{
    protected static $defaultName = 'gof:run';
    private Clock $clock;

    public function __construct(Clock $clock = null)
    {
        parent::__construct(null);
        $this->clock = $clock ?? new Clock();
    }

    protected function configure()
    {
        $this->setDescription('Runs the Game of life kata')
             ->addArgument('world', InputArgument::OPTIONAL, "The initial world as string", "... ... ...")
             ->addOption('generations', 'g', InputOption::VALUE_OPTIONAL, 'The number of generations created', 10);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $worldAsString = $input->getArgument('world');
        $world = array_map(fn($file) => str_split($file), explode(' ', $worldAsString));
        $gameOfLife = new GameOfLife($world);

        $output->writeln("\nGeneration Initial");
        $gameOfLife->print($output);

        $numberOfGenerations = (int) $input->getOption('generations');
        for ($currentGeneration = 1; $currentGeneration <= $numberOfGenerations; $currentGeneration++) {
            $output->writeln("\nGeneration $currentGeneration");
            $gameOfLife->run();
            $gameOfLife->print($output);
            $this->clock->wait(1000);
        }

        return 0;
    }
}
