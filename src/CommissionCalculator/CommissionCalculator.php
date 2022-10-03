<?php

declare(strict_types=1);

namespace App\CommissionCalculator;

use App\CommissionCalculator\Reader\BinListDataReader;
use App\CommissionCalculator\Reader\BinNumberCountryDataReader;
use App\CommissionCalculator\Reader\ExchangeRateDataReader;
use App\CommissionCalculator\Reader\ExchangeRatesApiDataReader;
use UnexpectedValueException;

class CommissionCalculator
{
    protected CommissionCalculatorConfig $config;
    protected BinNumberCountryDataReader $binNumberCountryDataReader;
    protected ExchangeRateDataReader $exchangeRateDataReader;

    public function __construct(
        CommissionCalculatorConfig $config,
        BinNumberCountryDataReader $binNumberCountryDataReader,
        ExchangeRateDataReader $exchangeRateDataReader
    ) {
        $this->config = $config;
        $this->binNumberCountryDataReader = $binNumberCountryDataReader;
        $this->exchangeRateDataReader = $exchangeRateDataReader;
    }

    public function calculate(string $commissionSourceName): array
    {
        $commissions = [];

        $transactions = explode("\n", file_get_contents($commissionSourceName));
        foreach ($transactions as $transaction) {
            if (empty($transaction)) {
                break;
            }

            ['bin' => $bin, 'amount' => $amount, 'currency' => $currency] = $this->fetchTransaction($transaction);

            $this->binNumberCountryDataReader->addBin($bin);
            if (!$this->binNumberCountryDataReader->hasCountryAlpha2()) {
                throw new UnexpectedValueException('Cannot get bin country.');
            }

            $this->exchangeRateDataReader->addCurrency($currency);
            $rate = $this->exchangeRateDataReader->getRate();

            if ($currency == 'EUR' or $rate == 0) {
                $amntFixed = $amount;
            }
            if ($currency != 'EUR' or $rate > 0) {
                $amntFixed = $amount / $rate;
            }

            $isEu = $this->isEu($this->binNumberCountryDataReader->getCountryAlpha2());

            $commission = $amntFixed * ($isEu === true ? 0.01 : 0.02);
            $commissions[] = $commission;

            echo sprintf("Currency: %s; Commission: %s", $currency, $commission);
            print "\n";
        }

        return $commissions;
    }

    protected function fetchTransaction($row): array
    {
        return json_decode($row, true);
    }

    protected function isEu($countryAlpha2): bool
    {
        return in_array($countryAlpha2, $this->config->getAllowedEuropeCountries());
    }
}
