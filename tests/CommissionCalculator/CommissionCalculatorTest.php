<?php

declare(strict_types=1);

namespace App\Tests\CommissionCalculator;

use App\CommissionCalculator\CommissionCalculatorFacade;
use App\CommissionCalculator\CommissionCalculatorFactory;
use App\CommissionCalculator\DataTransferObject\TransactionDto;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{
    public function testCalculation(): void
    {
        $source = __DIR__ . '/_data/input.txt';

        $expectCommissions = [
            1.0,
            0.6147044685326636,
            0.9315670734674131,
            1.5982316181849254,
            27.775077423028318,
        ];

        $calculatorFactory = new CommissionCalculatorFactory();
        $calculatorFacade = new CommissionCalculatorFacade($calculatorFactory);
        $transactions = $calculatorFacade->calculate($source);

        $transactionCommissions = array_map(function (TransactionDto $dto) {
            return $dto->getCommission();
        }, $transactions);

        $this->assertSame($expectCommissions, $transactionCommissions);
    }
}
