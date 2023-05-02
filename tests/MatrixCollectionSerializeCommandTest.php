<?php

require_once $_SERVER['DOCUMENT_ROOT'] . 'vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'app/Bootstrap.php';

use App\Grid;
use App\Interfaces\File;
use App\Interfaces\Matrix;
use App\Interfaces\MatrixCollectionInterface;
use App\Matrix\SerializeCommand;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class MatrixCollectionSerializeCommandTest extends TestCase
{
    public function testSeriazeMatrixCollection(): void
    {
        $testData = '1 1 1
1 1 1
1 1 1';

        $testcase = $this;

        /** @var File&MockObject $fileMock */
        $fileMock = $this->createMock(File::class);
        $fileMock
            ->method('setContent')
            ->willReturnCallback(function (string $data) use ($testcase, $testData, $fileMock) {
                $testcase->assertSame($data, $testData, 'Результат сериализации не совпадает с целевым значением');
                return $fileMock;
            });

        /** @var Matrix&MockObject $matrixMock */
        $matrixMock = $this->createMock(Matrix::class);
        $matrixMock
            ->method('getGrid')
            ->willReturn(new Grid([[1, 1, 1], [1, 1, 1], [1, 1, 1]]));

        /** @var MatrixCollectionInterface&MockObject $collectionMock */
        $collectionMock = $this->createMock(MatrixCollectionInterface::class);

        $collectionMock
            ->method('getIterator')
            ->willReturn(new ArrayIterator([$matrixMock]));

        $moveCommand = new SerializeCommand($fileMock, $collectionMock);
        $moveCommand->execute();
    }
}
