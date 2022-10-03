<?php

namespace App\Tests\CommissionCalculator;

use App\CommissionCalculator\Reader\ExchangeRatesApiDataReader;
use PHPUnit\Framework\TestCase;

class ExchangeRatesApiDataReaderTest extends TestCase
{
    /**
     * @return \Generator
     */
    public function getRatesTestData(): iterable
    {
        $source = __DIR__ . '/_data/exchangeratesapi.json';
        yield 'exchangeratesapi.fake.usd' => [
            [
                'source' => $source,
                'currency' => 'USD',
                'expect' => 0.813399,
            ],
        ];
        yield 'exchangeratesapi.fake.jpy' => [
            [
                'source' => $source,
                'currency' => 'JPY',
                'expect' => 107.346001,
            ],
        ];
    }

    /**
     * @dataProvider getRatesTestData
     *
     * @return void
     */
    public function testExchangeRates($input): void
    {
        $reader = new ExchangeRatesApiDataReader($input['source']);
        $reader->addCurrency($input['currency']);

        $this->assertSame($reader->getRate(), $input['expect']);
    }
}
