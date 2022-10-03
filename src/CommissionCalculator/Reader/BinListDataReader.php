<?php

namespace App\CommissionCalculator\Reader;

use UnexpectedValueException;

class BinListDataReader extends AbstractDataReader implements BinNumberCountryDataReader
{
    protected string $resource = '';
    protected string $bin;

    public function __construct(string $resource)
    {
        $this->resource = $resource;
    }

    public function addBin(string $bin): void
    {
        $this->bin = $bin;
    }

    public function getCountryAlpha2(): string
    {
        $data = $this->read();
        if (!$this->hasCountryAlpha2()) {
            throw new UnexpectedValueException('Cannot find "country" for BIN.');
        }

        return $data['country']['alpha2'];
    }

    public function hasCountryAlpha2(): bool
    {
        return $this->hasCountry() && array_key_exists('alpha2', $this->read()['country']);
    }

    protected function hasCountry(): bool
    {
        return !$this->isEmpty() && array_key_exists('country', $this->read());
    }

    protected function getSourceUrl(): string
    {
        return $this->resource . $this->bin;
    }
}
