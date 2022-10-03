<?php

namespace App\CommissionCalculator;

class CommissionCalculatorFacade
{
    protected CommissionCalculatorFactoryInterface $factory;

    public function __construct(CommissionCalculatorFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function calculate(string $commissionSourceName): array
    {
        return $this->factory->createCommissionCalculator()->calculate($commissionSourceName);
    }
}
