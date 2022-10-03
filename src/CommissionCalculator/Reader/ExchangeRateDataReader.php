<?php

namespace App\CommissionCalculator\Reader;

interface ExchangeRateDataReader
{
    public function getRate(): float;
}
