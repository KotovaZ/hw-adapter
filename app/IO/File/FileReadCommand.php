<?php

namespace App\IO\File;

use App\Exceptions\NotFoundException;
use App\Interfaces\Command;
use App\Interfaces\File;

class FileReadCommand implements Command
{
    private File $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function execute(): void
    {
        if (!file_exists($this->file->getPath())) {
            $message = sprintf('Файл по пути %s не найден', $this->file->getPath());
            throw new NotFoundException($message);
        }

        $fileData = file_get_contents($this->file->getPath());
        $this->file->setContent($fileData);
    }
}
