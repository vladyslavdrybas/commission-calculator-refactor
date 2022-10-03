<?php

declare(strict_types=1);

namespace App\CommissionCalculator;

use App\CommissionCalculator\Reader\BinListDataReader;

class CommissionCalculator
{
    public function calculate(string $commissionSourceName): array
    {
        $commissions = [];

        foreach (explode("\n", file_get_contents($commissionSourceName)) as $row) {
            if (empty($row)) break;

            $p = explode(",",$row);
            $p2 = explode(':', $p[0]);
            $value[0] = trim($p2[1], '"');
            $p2 = explode(':', $p[1]);
            $value[1] = trim($p2[1], '"');
            $p2 = explode(':', $p[2]);
            $value[2] = trim($p2[1], '"}');

            $binNumberCountryInfo = new BinListDataReader('https://lookup.binlist.net/', $value[0]);
            if (!$binNumberCountryInfo->hasCountryAlpha2())
                die('error!');

            $isEu = $this->isEu($binNumberCountryInfo->getCountryAlpha2());

            $rate = @json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true)['rates'][$value[2]];

            if ($value[2] == 'EUR' or $rate == 0) {
                $amntFixed = $value[1];
            }
            if ($value[2] != 'EUR' or $rate > 0) {
                $amntFixed = $value[1] / $rate;
            }

            $commission = $amntFixed * ($isEu == 'yes' ? 0.01 : 0.02);
            $commissions[] = $commission;

            echo $commission;
            print "\n";
        }

        return $commissions;
    }

    protected function isEu($c): string
    {
        $result = false;

        switch($c) {
            case 'AT':
            case 'BE':
            case 'BG':
            case 'CY':
            case 'CZ':
            case 'DE':
            case 'DK':
            case 'EE':
            case 'ES':
            case 'FI':
            case 'FR':
            case 'GR':
            case 'HR':
            case 'HU':
            case 'IE':
            case 'IT':
            case 'LT':
            case 'LU':
            case 'LV':
            case 'MT':
            case 'NL':
            case 'PO':
            case 'PT':
            case 'RO':
            case 'SE':
            case 'SI':
            case 'SK':
                $result = 'yes';
                return $result;
            default:
                $result = 'no';
        }
        return $result;
    }
}
