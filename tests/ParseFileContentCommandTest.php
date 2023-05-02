<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'app/Bootstrap.php';

use App\Interfaces\File;
use App\Interfaces\Matrix;
use App\Interfaces\MatrixCollectionInterface;
use App\IO\File\ParseFileContentCommand;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class ParseFileContentCommandTest extends TestCase
{
    public function testParseFile(): void
    {
        $testData = '89 79 26
18 23 66
12 42 91';

        $testcase = $this;

        /** @var File&MockObject $fileMock */
        $fileMock = $this->createMock(File::class);
        $fileMock
            ->method('getContent')
            ->willReturn($testData);

        /** @var MatrixCollectionInterface&MockObject $collectionMock */
        $collectionMock = $this->createMock(MatrixCollectionInterface::class);
        $collectionMock
            ->expects($this->once())
            ->method('add');

        $collectionMock
            ->method('add')
            ->willReturnCallback(function (Matrix $matrix) {
                $this->assertInstanceOf(Matrix::class, $matrix);

                $grid = $matrix->getGrid();
                list($rows, $columns) = $grid->getSize();

                $this->assertSame($rows, 3, 'Неверное количество строк');
                $this->assertSame($columns, 3, 'Неверное количество столбцов');
            });

        $moveCommand = new ParseFileContentCommand($fileMock, $collectionMock);
        $moveCommand->execute();
    }
}
