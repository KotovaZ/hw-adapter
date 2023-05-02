<?php

namespace App\IO\File;

use App\Exceptions\Exception;
use App\Exceptions\NotFoundException;
use App\Interfaces\Command;
use App\Interfaces\File;

class FileWriteCommand implements Command
{
    private File $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function execute(): void
    {
        $isSuccess = file_put_contents($this->file->getPath(), $this->file->getContent());

        if (!$isSuccess) {
            throw new Exception('Не удалось записать файл');
        }
    }
}
