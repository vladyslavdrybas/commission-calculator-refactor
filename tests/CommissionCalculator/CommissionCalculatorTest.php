<?php

declare(strict_types=1);

namespace App\Tests\CommissionCalculator;

use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{
    public function test(): void
    {
        $source = __DIR__ . '/_data/input.txt';
        (new \App\CommissionCalculator\CommissionCalculator())->calculate($source);
    }
}
