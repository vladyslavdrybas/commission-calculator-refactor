<?php

namespace App\CommissionCalculator\Plugins;

use App\CommissionCalculator\CommissionCalculatorConfig;
use App\CommissionCalculator\DataTransferObject\TransactionDto;
use App\CommissionCalculator\Reader\BinNumberCountryDataReader;
use UnexpectedValueException;

class CommissionForCountryLocationModifier implements CommissionModifier
{
    protected BinNumberCountryDataReader $binNumberCountryDataReader;
    protected CommissionCalculatorConfig $config;

    public function __construct(
        CommissionCalculatorConfig $config,
        BinNumberCountryDataReader $binNumberCountryDataReader
    ) {
        $this->binNumberCountryDataReader = $binNumberCountryDataReader;
        $this->config = $config;
    }

    public function modify(TransactionDto $dto): TransactionDto
    {
        $this->binNumberCountryDataReader->addBin($dto->getBin());
        if (!$this->binNumberCountryDataReader->hasCountryAlpha2()) {
            throw new UnexpectedValueException('Cannot get bin country.');
        }

        $isEu = $this->isEu($this->binNumberCountryDataReader->getCountryAlpha2());
        $modifier = $isEu === true ? 0.01 : 0.02;

        $dto->setCommission($dto->getCommission() * $modifier);

        return $dto;
    }

    protected function isEu($countryAlpha2): bool
    {
        return in_array($countryAlpha2, $this->config->getAllowedEuropeCountries());
    }
}
