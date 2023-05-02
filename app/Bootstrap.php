<?php

use App\Interfaces\UObject;
use App\IO\File\FileReadCommand;
use App\IO\File\FileWriteCommand;
use App\IO\File\ParseFileContentCommand;
use App\IoC\AdapterGenerateCommand;
use App\IoC\IoC;
use App\Matrix\CombineCommand;
use App\Matrix\GenerateCollection;
use App\Matrix\GenerateCommand;
use App\Matrix\MatrixGeneratorCommand;
use App\Matrix\SerializeCommand;
use App\Matrix\SumCommand;

IoC::resolve(
    'IoC.Register',
    'Adapter',
    function (string $interface, UObject $target) {
        $refInterface = new ReflectionClass($interface);
        $className = $refInterface->getShortName() . "Adapter";

        if (!class_exists($className)) (new AdapterGenerateCommand($interface))->execute();

        return new ($className)($target);
    }
)->execute();


IoC::resolve(
    'IoC.Register',
    'IO.File.Read',
    fn (...$attrs) => new FileReadCommand($attrs[0])
)->execute();

IoC::resolve(
    'IoC.Register',
    'IO.File.Write',
    fn (...$attrs) => new FileWriteCommand($attrs[0])
)->execute();

IoC::resolve(
    'IoC.Register',
    'File.Parse',
    fn (...$attrs) => new ParseFileContentCommand($attrs[0], $attrs[1])
)->execute();

IoC::resolve(
    'IoC.Register',
    'Matrix.Command.Combine',
    fn (...$attrs) => new CombineCommand($attrs[0], $attrs[1])
)->execute();

IoC::resolve(
    'IoC.Register',
    'MatrixGeneratorCommand',
    fn (...$attrs) => new MatrixGeneratorCommand($attrs[0], $attrs[1], $attrs[2])
)->execute();

IoC::resolve(
    'IoC.Register',
    'Matrix.Command.Generate',
    fn (...$attrs) => new GenerateCommand($attrs[0], $attrs[1], $attrs[2])
)->execute();

IoC::resolve(
    'IoC.Register',
    'Matrix.Command.GenerateCollection',
    fn (...$attrs) => new GenerateCollection($attrs[0], $attrs[1], $attrs[2])
)->execute();

IoC::resolve(
    'IoC.Register',
    'Matrix.Command.Sum',
    fn (...$attrs) => new SumCommand($attrs[0], $attrs[1])
)->execute();

IoC::resolve(
    'IoC.Register',
    'Matrix.Command.Serialize',
    fn (...$attrs) => new SerializeCommand($attrs[0], $attrs[1])
)->execute();
