<?php

namespace App\Matrix;

use App\Interfaces\Command;
use App\Interfaces\File;
use App\IoC\IoC;
use App\MacroCommand;

class MatrixGeneratorCommand implements Command
{

    public function __construct(private int $count, private array $size, private File $output)
    {
    }

    public function execute(): void
    {
        $collection = new MatrixCollection;
        $collectionGenerateCommand = IoC::resolve('Matrix.Command.GenerateCollection', $collection, $this->count, $this->size);
        $serializeCommand = IoC::resolve('Matrix.Command.Serialize', $this->output, $collection);
        $fileWriteCommand = IoC::resolve('IO.File.Write', $this->output);

        $command = new MacroCommand(
            $collectionGenerateCommand,
            $serializeCommand,
            $fileWriteCommand
        );

        $command->execute();
    }
}
