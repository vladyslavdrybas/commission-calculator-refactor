<?php

declare(strict_types=1);

namespace App\CommissionCalculator;

use App\CommissionCalculator\Reader\BinListDataReader;
use App\CommissionCalculator\Reader\ExchangeRatesApiDataReader;
use UnexpectedValueException;

class CommissionCalculator
{
    protected CommissionCalculatorConfig $config;

    public function __construct(CommissionCalculatorConfig $config)
    {
        $this->config = $config;
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

            $binNumberCountryInfo = new BinListDataReader($this->config->getBinListApiSource(), $bin);
            if (!$binNumberCountryInfo->hasCountryAlpha2()) {
                throw new UnexpectedValueException('Cannot get bin country.');
            }

            $exchangeRateInfo = new ExchangeRatesApiDataReader($this->config->getExchangeRatesApiSource(), $currency);
            $rate = $exchangeRateInfo->getRate();

            if ($currency == 'EUR' or $rate == 0) {
                $amntFixed = $amount;
            }
            if ($currency != 'EUR' or $rate > 0) {
                $amntFixed = $amount / $rate;
            }

            $isEu = $this->isEu($binNumberCountryInfo->getCountryAlpha2());

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
