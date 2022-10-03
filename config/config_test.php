<?php
return array_merge(
    require_once __DIR__ . '/config.php',
    [
        \App\CommissionCalculator\CommissionCalculatorConstants::KEY_EXCHANGE_RATES_API_SOURCE => dirname(__DIR__) . '/tests/CommissionCalculator/_data/exchangeratesapi.json',
    ]
);
