<?php

declare(strict_types=1);

namespace App\Tests\CommissionCalculator;

use App\CommissionCalculator\CommissionCalculatorFacade;
use App\CommissionCalculator\CommissionCalculatorFactory;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{
    public function testCalculation(): void
    {
        $source = __DIR__ . '/_data/input.txt';

        $calculatorFactory = new CommissionCalculatorFactory();
        $calculatorFacade = new CommissionCalculatorFacade($calculatorFactory);
        $calculatorFacade->calculate($source);
    }
}
