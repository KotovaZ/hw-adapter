<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'app/Bootstrap.php';

use App\Grid;
use App\Interfaces\Command;
use App\Interfaces\File;
use App\IoC\IoC;
use App\Matrix\CombineCommand;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class MatrixCombineCommandTest extends TestCase
{
    private string $inputFileContent;
    private string $outputFileContent;

    public function testResolved(): void
    {
        /** @var File&MockObject $inputFileMock */
        $inputFileMock = $this->createMock(File::class);
        $inputFileMock
            ->expects($this->once())
            ->method('getContent')
            ->willReturn($this->inputFileContent);

        /** @var File&MockObject $outputFileMock */
        $outputFileMock = $this->createMock(File::class);
        $outputFileMock
            ->expects($this->once())
            ->method('setContent')
            ->willReturnCallback(function (string $data) use ($outputFileMock) {
                $this->assertSame(
                    $data,
                    $this->outputFileContent,
                    'Результат сложения матриц не совпадает с целевым значением'
                );
                return $outputFileMock;
            });

        IoC::resolve(
            'IoC.Register',
            'IO.File.Read',
            fn (...$attrs) => $this->createMock(Command::class)
        )->execute();

        IoC::resolve(
            'IoC.Register',
            'IO.File.Write',
            fn (...$attrs) => $this->createMock(Command::class)
        )->execute();

        $moveCommand = new CombineCommand($inputFileMock, $outputFileMock);
        $moveCommand->execute();
    }

    protected function setUp(): void
    {
        $this->inputFileContent = '1 1 1
1 1 1
1 1 1

1 1 1
1 1 1
1 1 1';

        $this->outputFileContent = '2 2 2
2 2 2
2 2 2';
    }
}
