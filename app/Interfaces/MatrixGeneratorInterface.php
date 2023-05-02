<?php

namespace App\Interfaces;

interface MatrixGeneratorInterface
{    
    /**
     * @param int $count
     * @param int[] $size
     * @param File $output
     * @return void
     */
    public static function generate(int $count, array $size, File $output): void;
}
