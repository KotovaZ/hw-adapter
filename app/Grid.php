<?php

namespace App;

use App\Exceptions\UndefinedValueException;

class Grid
{
    public function __construct(private array $data)
    {
    }

    public function getSize(): array
    {

        return [
            count($this->data),
            count($this->data[0])
        ];
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getValue(int $row, int $column): float
    {
        if (empty($this->data) || empty($this->data[$row]) || !isset($this->data[$row][$column]))
            throw new UndefinedValueException('Позиция не определена');

        return (float)$this->data[$row][$column];
    }
}
