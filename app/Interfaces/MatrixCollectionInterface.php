<?php

namespace App\Interfaces;

use IteratorAggregate;

interface MatrixCollectionInterface extends IteratorAggregate
{
    public function add(Matrix $matrix): self;
    public function sum(): Matrix;
}
