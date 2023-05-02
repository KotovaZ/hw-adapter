<?php

namespace App\Matrix;

use App\Interfaces\Command;
use App\Interfaces\File;
use App\Interfaces\Matrix;
use App\Interfaces\MatrixCollectionInterface;

class SerializeCommand implements Command
{
    public function __construct(
        private File $file,
        private MatrixCollectionInterface $collection
    ) {
    }

    public function execute(): void
    {
        $matrixList = array_map(
            fn ($matrix) => $this->serializeMatrix($matrix),
            iterator_to_array($this->collection->getIterator())
        );
        $result = implode(PHP_EOL . PHP_EOL, $matrixList);

        $this->file->setContent($result);
    }

    private function serializeMatrix(Matrix $matrix)
    {
        $rowsData = $matrix->getGrid()->getData();
        $rows = array_map(
            fn ($row) => $this->serializeRow($row),
            $rowsData
        );
        return implode(PHP_EOL, $rows);
    }

    private function serializeRow(array $row): string
    {
        return implode(' ', $row);
    }
}
