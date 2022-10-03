<?php

namespace App\CommissionCalculator;

use App\AbstractModuleConfig;

class CommissionCalculatorConfig extends AbstractModuleConfig
{
    public function getAllowedEuropeCountries(): array
    {
        return CommissionCalculatorConstants::ALLOWED_EUROPE_COUNTRIES;
    }

    public function getBinListApiSource(): string
    {
        return $this->get(CommissionCalculatorConstants::KEY_BIN_LIST_API_SOURCE)
            ?? 'https://lookup.binlist.net/';
    }

    public function getExchangeRatesApiSource(): string
    {
        return $this->get(CommissionCalculatorConstants::KEY_EXCHANGE_RATES_API_SOURCE)
            ?? 'https://api.exchangeratesapi.io/latest?base=EUR';
    }
}
