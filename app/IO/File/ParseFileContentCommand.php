<?php

namespace App\IO\File;

use App\Grid;
use App\Interfaces\Command;
use App\Interfaces\File;
use App\Interfaces\Matrix;
use App\Interfaces\MatrixCollectionInterface;
use App\IoC\IoC;
use App\MapObject;
use App\Matrix\MatrixCollection;

class ParseFileContentCommand implements Command
{
    public function __construct(
        private File $file,
        private MatrixCollectionInterface $collection
    ) {
    }

    public function execute(): void
    {
        $matrixDataList = preg_split("/(^$)/m", $this->file->getContent());

        foreach ($matrixDataList as $matrixData) {
            $matrixData = trim($matrixData);
            $matrix = IoC::resolve('Adapter', Matrix::class, new MapObject);

            $gridData = array_map(
                fn ($row) => preg_split('/\s+/', $row),
                explode(PHP_EOL, $matrixData)
            );

            $matrix->setGrid(new Grid($gridData));
            $this->collection->add($matrix);
        }
    }
}
