<?php

namespace App\Interfaces;

interface MatrixCombinerInterface
{
    public static function combine(File $input, File $output);
}
