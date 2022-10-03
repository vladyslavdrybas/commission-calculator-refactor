<?php

namespace App\Tests\CommissionCalculator;

use App\CommissionCalculator\Reader\BinListDataReader;
use App\CommissionCalculator\Reader\BinNumberCountryDataReader;
use App\CommissionCalculator\Reader\DataReader;
use PHPUnit\Framework\TestCase;

class BinListDataReaderTest extends TestCase
{
    /**
     * @return \Generator
     */
    public function getCountriesFromFile(): iterable
    {
        yield 'FILE.Lithuania.LT' => [
            [
                'source' => __DIR__ . '/_data/bin_result/',
                'object' => '516793.json',
                'expect' => ['alpha2' => 'LT'],
            ],
        ];
    }

    /**
     * @return \Generator
     */
    public function getCountriesFromApi(): iterable
    {
        $apiUrl = 'https://lookup.binlist.net/';

        yield 'API.Lithuania.LT' => [
            [
                'source' => $apiUrl,
                'object' => '516793',
                'expect' => ['alpha2' => 'LT'],
            ],
        ];
        yield 'API.United_Kingdom.GB' => [
            [
                'source' => $apiUrl,
                'object' => '4745030',
                'expect' => ['alpha2' => 'GB'],
            ],
        ];
        yield 'API.USA.US' => [
            [
                'source' => $apiUrl,
                'object' => '41417360',
                'expect' => ['alpha2' => 'US'],
            ],
        ];
        yield 'API.Japan.JP' => [
            [
                'source' => $apiUrl,
                'object' => '45417360',
                'expect' => ['alpha2' => 'JP'],
            ],
        ];
        yield 'API.Denmark.DK' => [
            [
                'source' => $apiUrl,
                'object' => '45717360',
                'expect' => ['alpha2' => 'DK'],
            ],
        ];
    }

    public function testInheritance(): void
    {
        $reader = new BinListDataReader('', '');
        $this->assertInstanceOf(BinNumberCountryDataReader::class, $reader);
        $this->assertInstanceOf(DataReader::class, $reader);
    }

    public function testUnexpectedValueException(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $reader = new BinListDataReader(__DIR__ . '/_data/bin_result/', 'unknown.json');
        $reader->getCountryAlpha2();
    }

    /**
     * @dataProvider getCountriesFromFile
     * @dataProvider getCountriesFromApi
     *
     * @return void
     */
    public function testCountryAlpha2($input): void
    {
        $reader = new BinListDataReader($input['source'], $input['object']);

        $this->assertSame($reader->getCountryAlpha2(), $input['expect']['alpha2']);
    }
}
