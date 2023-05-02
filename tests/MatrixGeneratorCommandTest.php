<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'app/Bootstrap.php';

use App\Interfaces\Command;
use App\Interfaces\File;
use App\IoC\IoC;
use App\Matrix\MatrixGeneratorCommand;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class MatrixGeneratorCommandTest extends TestCase
{
    public function testMatrixGeneratedCorrectly(): void
    {
        /** @var File&MockObject $inputFileMock */
        $inputFileMock = $this->createMock(File::class);

        /** @var File&MockObject $outputFileMock */
        $outputFileMock = $this->createMock(File::class);
        $outputFileMock
            ->expects($this->once())
            ->method('setContent')
            ->willReturnCallback(function (string $data) use ($outputFileMock) {
                preg_match_all('/(\d*?\s\d*\s\d*$)/ms', $data, $matches, PREG_SET_ORDER, 0);
                $rowsCount = count($matches);
                $this->assertSame(
                    $rowsCount,
                    6,
                    'Генерация матриц сработала некорректно'
                );
                return $outputFileMock;
            });

        IoC::resolve(
            'IoC.Register',
            'IO.File.Write',
            fn (...$attrs) => $this->createMock(Command::class)
        )->execute();

        $moveCommand = new MatrixGeneratorCommand(2, [3, 3], $outputFileMock);
        $moveCommand->execute();
    }
}
