<?php

namespace App\Matrix;

use App\Interfaces\Command;
use App\Interfaces\File;
use App\Interfaces\Matrix;
use App\IoC\IoC;
use App\MacroCommand;
use App\MapObject;

class CombineCommand implements Command
{

    public function __construct(private File $input, private File $output)
    {
    }

    public function execute(): void
    {
        $collection = new MatrixCollection;
        $resultMatrix = IoC::resolve('Adapter', Matrix::class, new MapObject);

        $fileReadCommand = IoC::resolve('IO.File.Read', $this->input);
        $fileParseCommand = IoC::resolve('File.Parse', $this->input, $collection);
        $sumCommand = IoC::resolve('Matrix.Command.Sum', $collection, $resultMatrix);
        $serializeCommand = IoC::resolve(
            'Matrix.Command.Serialize',
            $this->output,
            new MatrixCollection($resultMatrix)
        );

        $fileWriteCommand = IoC::resolve('IO.File.Write', $this->output);

        $command = new MacroCommand($fileReadCommand, $fileParseCommand, $sumCommand, $serializeCommand, $fileWriteCommand);
        $command->execute();
    }
}
