<?php

namespace App\CommissionCalculator;

class CommissionCalculatorFactory implements CommissionCalculatorFactoryInterface
{
    public function createCommissionCalculator(): CommissionCalculator
    {
        return new CommissionCalculator();
    }
}
