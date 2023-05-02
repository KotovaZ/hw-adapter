<?php

namespace App\Matrix;

use App\Exceptions\UndefinedValueException;
use App\Grid;
use App\Interfaces\Matrix;
use App\Interfaces\MatrixCollectionInterface;
use App\IoC\IoC;
use App\MapObject;
use ArrayIterator;
use Traversable;

class MatrixCollection implements MatrixCollectionInterface
{

    /** @var Matrix[] */
    private array $list = [];
    
    public function __construct(Matrix ...$matrix)
    {
        $this->list = $matrix;
    }

    public function add(Matrix $matrix): self
    {
        $this->list[] = $matrix;
        return $this;
    }

    /**
     * @throws UndefinedValueException
     * @return Matrix
     */
    public function sum(): Matrix
    {
        if (empty($this->list)) {
            throw new UndefinedValueException("Набор матриц не заполнен", 1);
        }

        $targetGrid = $this->list[0]->getGrid();
        for ($i = 1; $i < count($this->list); $i++) {
            $grid = $this->list[$i]->getGrid();

            list($rows, $cols) = $grid->getSize();
            $result = [];

            for ($i = 0; $i < $rows; $i++) {
                for ($j = 0; $j < $cols; $j++) {
                    $result[$i][$j] = $targetGrid->getValue($i, $j) + $grid->getValue($i, $j);
                }
            }

            $targetGrid = new Grid($result);
        }

        $matrix = IoC::resolve('Adapter', Matrix::class, new MapObject);
        $matrix->setGrid($targetGrid);

        return $matrix;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->list);
    }
}
