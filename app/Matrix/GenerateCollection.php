<?php

namespace App\Matrix;

use App\Interfaces\Command;
use App\Interfaces\Matrix;
use App\IoC\IoC;
use App\MapObject;

class GenerateCollection implements Command
{

    public function __construct(private MatrixCollection $collection, private int $count, private array $size = [3, 3])
    {
    }

    public function execute(): void
    {
        for ($i = 0; $i < $this->count; $i++) {
            $matrix = IoC::resolve('Adapter', Matrix::class, new MapObject);
            IoC::resolve('Matrix.Command.Generate', $matrix, $this->size[0], $this->size[1])->execute();
            $this->collection->add($matrix);
        }
    }
}
