<?php

namespace App;

use App\Interfaces\File;
use App\Interfaces\MatrixCombinerInterface;
use App\IoC\IoC;

class MatrixCombinerAdapter implements MatrixCombinerInterface
{
    public static function combine(File $input, File $output)
    {
        IoC::resolve('Matrix.Command.Combine', $input, $output)->execute();
    }
}
