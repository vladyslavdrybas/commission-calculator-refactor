<?php

namespace App\CommissionCalculator\Reader;

interface DataReader
{
    public function read(): array;
    public function isEmpty(): bool;
}
