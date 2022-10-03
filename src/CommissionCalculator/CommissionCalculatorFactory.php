<?php

namespace App\CommissionCalculator;

use App\CommissionCalculator\Reader\BinListDataReader;

class CommissionCalculatorFactory implements CommissionCalculatorFactoryInterface
{
    protected CommissionCalculatorConfig $config;

    public function createCommissionCalculator(): CommissionCalculator
    {
        return new CommissionCalculator(
            $this->createConfig(),
            new BinListDataReader($this->config->getBinListApiSource())
        );
    }

    public function createConfig(): CommissionCalculatorConfig
    {
        if (!isset($this->config)) {
            $this->config = new CommissionCalculatorConfig();
        }

        return $this->config;
    }
}
