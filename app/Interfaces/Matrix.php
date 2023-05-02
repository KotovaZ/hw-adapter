<?php

namespace App\Interfaces;

use App\Grid;

interface Matrix
{
    public function getGrid(): Grid;
    public function setGrid(Grid $grid): self;
}
