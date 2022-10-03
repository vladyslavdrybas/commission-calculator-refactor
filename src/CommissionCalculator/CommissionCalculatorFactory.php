<?php

namespace App\CommissionCalculator;

use App\CommissionCalculator\Plugins\CommissionCurrencyRateModifier;
use App\CommissionCalculator\Plugins\CommissionForCountryLocationModifier;
use App\CommissionCalculator\Reader\BinListDataReader;
use App\CommissionCalculator\Reader\ExchangeRatesApiDataReader;

class CommissionCalculatorFactory implements CommissionCalculatorFactoryInterface
{
    protected CommissionCalculatorConfig $config;

    public function createCommissionCalculator(): CommissionCalculator
    {
        return new CommissionCalculator($this->getCommissionModifiers());
    }

    public function getCommissionModifiers(): array
    {
        return [
            new CommissionForCountryLocationModifier(
                $this->getConfig(),
                new BinListDataReader($this->getConfig()->getBinListApiSource())
            ),
            new CommissionCurrencyRateModifier(
                new ExchangeRatesApiDataReader($this->getConfig()->getExchangeRatesApiSource())
            )
        ];
    }

    public function getConfig(): CommissionCalculatorConfig
    {
        if (!isset($this->config)) {
            $this->config = new CommissionCalculatorConfig();
        }

        return $this->config;
    }
}
