<?php

declare(strict_types=1);

namespace App\CommissionCalculator;

use App\CommissionCalculator\DataTransferObject\TransactionDto;

class CommissionCalculator
{
    protected array $modifiers;

    public function __construct(array $modifiers)
    {
        $this->modifiers = $modifiers;
    }

    public function calculate(string $commissionSourceName): array
    {
        $transactions = explode("\n", file_get_contents($commissionSourceName));
        $transactionsCollection = [];
        foreach ($transactions as $key => $transaction) {
            if (empty($transaction)) {
                break;
            }

            ['bin' => $bin, 'amount' => $amount, 'currency' => $currency] = $this->fetchTransaction($transaction);

            $transactionDto = new TransactionDto($bin, $amount * 1.0, $currency);

            foreach ($this->modifiers as $modifier) {
                $modifier->modify($transactionDto);
            }

            $transactionsCollection[$key] = $transactionDto;
        }

        return $transactionsCollection;
    }

    protected function fetchTransaction($row): array
    {
        return json_decode($row, true);
    }
}
