<?php

namespace App\CommissionCalculator\Reader;

interface ExchangeRateDataReader
{
    public function getRate(): float;
    public function addCurrency(string $currency): void;
}
