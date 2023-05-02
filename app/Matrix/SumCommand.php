<?php

namespace App\Matrix;

use App\Interfaces\Command;
use App\Interfaces\Matrix;

class SumCommand implements Command
{

    public function __construct(private MatrixCollection $collection, private Matrix $matrix)
    {
    }

    public function execute(): void
    {
        $collectionSumMatrix = $this->collection->sum();
        $this->matrix->setGrid($collectionSumMatrix->getGrid());
    }
}
