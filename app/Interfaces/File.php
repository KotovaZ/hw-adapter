<?php

namespace App\Interfaces;

interface File
{
    public function getPath(): string;
    public function setPath(string $path): self;
    public function getContent(): mixed;
    public function setContent(mixed $content): self;
}
