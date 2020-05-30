<?php

declare(strict_types = 1);

namespace Katas;

use Symfony\Component\Console\Output\OutputInterface;

class World
{
    private array $cells;

    public function __construct(array $cells)
    {
        $this->cells = $cells;
    }

    public function nextGeneration(): World
    {
        if ($this->hasTwoNeighbors()) {
            return new World([
                ['.', '.', '.'],
                ['.', '*', '.'],
                ['.', '.', '.'],
            ]);
        }

        return new World([
            ['.', '.', '.'],
            ['.', '.', '.'],
            ['.', '.', '.'],
        ]);
    }

    public function print(OutputInterface $output)
    {
        foreach ($this->cells as $file) {
            $output->writeln(implode('', $file));
        }
    }

    public function at(int $row, int $col): string
    {
        return $this->cells[$row][$col];
    }

    protected function hasTwoNeighbors(): bool
    {
        $count = 0;
        $neighbors = [
            ['row' => 0, 'col' => 0],
            ['row' => 0, 'col' => 1],
            ['row' => 0, 'col' => 2],
            ['row' => 1, 'col' => 0],
            ['row' => 1, 'col' => 2],
        ];
        foreach ($neighbors as $coordinated) {
            $count += $this->at($coordinated['row'], $coordinated['col']) === '*' ? 1 : 0;
        }

        return ($count === 2);
    }
}
