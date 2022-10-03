<?php

namespace App\CommissionCalculator;

interface CommissionCalculatorConstants
{
    public const KEY_BIN_LIST_API_SOURCE = self::class . ':KEY_BIN_LIST_API_SOURCE';
    public const KEY_EXCHANGE_RATES_API_SOURCE = self::class . ':KEY_EXCHANGE_RATES_API_SOURCE';

    public const ALLOWED_EUROPE_COUNTRIES = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'];
}
