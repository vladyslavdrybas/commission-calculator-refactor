<?php

namespace App\CommissionCalculator;

use App\AbstractModuleConfig;

class CommissionCalculatorConfig extends AbstractModuleConfig
{
    public function getBinReaderResource(): string
    {
        return $this->get(CommissionCalculatorConstants::KEY_BIN_SOURCE_URL);
    }

    public function getAllowedEuropeCountries(): array
    {
        return CommissionCalculatorConstants::ALLOWED_EUROPE_COUNTRIES;
    }
}
