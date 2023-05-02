<?php

namespace App;

use App\Interfaces\File;
use App\Interfaces\MatrixGeneratorInterface;
use App\IoC\IoC;

class MatrixGeneratorAdapter implements MatrixGeneratorInterface
{
    public static function generate(int $count, array $size, File $output): void
    {
        IoC::resolve('MatrixGeneratorCommand', $count, $size, $output)->execute();
        //Вызов программы 1
        //IoC::resolve('Matrix.Command.Combine', $output, $output)->execute();
    }
}
