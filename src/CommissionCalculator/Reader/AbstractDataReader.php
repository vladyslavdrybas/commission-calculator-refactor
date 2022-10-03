<?php

namespace App\CommissionCalculator\Reader;

abstract class AbstractDataReader implements DataReader
{
    protected array $data = [];

    abstract protected function getSourceUrl(): string;

    public function isEmpty(): bool
    {
        return empty($this->read());
    }

    public function read(): array
    {
        if (empty($this->data)) {
            $this->data = json_decode(file_get_contents($this->getSourceUrl()), true);
        }

        return $this->data;
    }
}
