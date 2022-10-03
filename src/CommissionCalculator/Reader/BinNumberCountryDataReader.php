<?php

namespace App\CommissionCalculator\Reader;

interface BinNumberCountryDataReader
{
    public function getCountryAlpha2(): string;
    public function hasCountryAlpha2(): bool;
    public function addBin(string $bin): void;
}
