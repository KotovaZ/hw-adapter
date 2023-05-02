<?php

namespace App\Matrix;

use App\Grid;
use App\Interfaces\Command;
use App\Interfaces\Matrix;

class GenerateCommand implements Command
{

    public function __construct(private Matrix $matrix, private int $rows, private int $columns)
    {
    }

    public function execute(): void
    {
        $rows = [];
        for ($i = 0; $i < $this->rows; $i++) {
            $row = [];
            for ($z = 0; $z < $this->columns; $z++) {
                $row[] = mt_rand(0, 100);
            }
            $rows[] = $row;
        }

        $this->matrix->setGrid(new Grid($rows));
    }
}
