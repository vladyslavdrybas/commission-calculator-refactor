<?php

namespace App\CommissionCalculator;

interface CommissionCalculatorFactoryInterface
{
    public function createCommissionCalculator(): CommissionCalculator;
    public function createConfig(): CommissionCalculatorConfig;
}
