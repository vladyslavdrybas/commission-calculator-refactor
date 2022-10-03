<?php

declare(strict_types=1);

namespace App\CommissionCalculator;

use App\CommissionCalculator\Reader\BinListDataReader;
use App\CommissionCalculator\Reader\ExchangeRatesApiDataReader;

class CommissionCalculator
{
    protected CommissionCalculatorConfig $config;

    public function __construct(CommissionCalculatorConfig $config) {
        $this->config = $config;
    }

    public function calculate(string $commissionSourceName): array
    {
        $commissions = [];

        foreach (explode("\n", file_get_contents($commissionSourceName)) as $row) {
            if (empty($row)) break;

            $p = explode(",",$row);
            $p2 = explode(':', $p[0]);
            $value[0] = trim($p2[1], '"');
            $bin = $value[0];

            $p2 = explode(':', $p[1]);
            $value[1] = trim($p2[1], '"');
            $amount = $value[1];

            $p2 = explode(':', $p[2]);
            $value[2] = trim($p2[1], '"}');
            $currency = $value[2];

            $binNumberCountryInfo = new BinListDataReader('https://lookup.binlist.net/', $bin);
            if (!$binNumberCountryInfo->hasCountryAlpha2())
                die('error!');


            $rate = (new ExchangeRatesApiDataReader('https://api.exchangeratesapi.io/latest', $currency))->getRate();

            if ($currency == 'EUR' or $rate == 0) {
                $amntFixed = $amount;
            }
            if ($currency != 'EUR' or $rate > 0) {
                $amntFixed = $amount / $rate;
            }

            $isEu = $this->isEu($binNumberCountryInfo->getCountryAlpha2());

            $commission = $amntFixed * ($isEu === true  ? 0.01 : 0.02);
            $commissions[] = $commission;

            echo $commission;
            print "\n";
        }

        return $commissions;
    }

    protected function isEu($countryAlpha2): bool
    {
        return in_array($countryAlpha2, $this->config->getAllowedEuropeCountries());
    }
}
