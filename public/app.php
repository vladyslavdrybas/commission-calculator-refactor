<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (empty($argv[1])) {
    throw new \Exception('Please, use attribute to set commissions source.');
}

(new \App\CommissionCalculator\CommissionCalculator())->calculate($argv[1]);
