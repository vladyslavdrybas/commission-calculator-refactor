<?php

namespace App\CommissionCalculator;

use App\CommissionCalculator\DataTransferObject\TransactionDto;

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

    public function printTransactionTransfers(array $transactions): void
    {
        foreach ($transactions as $transaction) {
            /** @var TransactionDto $transaction */
            echo $transaction->getCommission();
            print "\n";
        }
    }
}
