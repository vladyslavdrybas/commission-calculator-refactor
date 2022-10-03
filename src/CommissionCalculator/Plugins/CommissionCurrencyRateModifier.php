<?php

namespace App\CommissionCalculator\Plugins;

use App\CommissionCalculator\DataTransferObject\TransactionDto;
use App\CommissionCalculator\Reader\ExchangeRateDataReader;

class CommissionCurrencyRateModifier implements CommissionModifier
{
    protected ExchangeRateDataReader $exchangeRateDataReader;

    public function __construct(ExchangeRateDataReader $exchangeRateDataReader)
    {
        $this->exchangeRateDataReader = $exchangeRateDataReader;
    }

    public function modify(TransactionDto $dto): TransactionDto
    {
        $this->exchangeRateDataReader->addCurrency($dto->getCurrency());
        $rate = $this->exchangeRateDataReader->getRate();

        if ($dto->getCurrency() != 'EUR' or $rate > 0) {
            $dto->setCommission($dto->getCommission() / $rate);
        }

        return $dto;
    }
}
