<?php

declare(strict_types=1);

use App\CommissionCalculator\CommissionCalculatorFacade;
use App\CommissionCalculator\CommissionCalculatorFactory;

require_once dirname(__DIR__) . '/vendor/autoload.php';

if (empty($argv[1])) {
    throw new \Exception('Please, use attribute to set commissions source.');
}
$source = $argv[1];
$calculatorFactory = new CommissionCalculatorFactory();

$calculatorFacade = new CommissionCalculatorFacade($calculatorFactory);
$transactions = $calculatorFacade->calculate($source);
$calculatorFacade->printTransactionTransfers($transactions);
