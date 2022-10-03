<?php

namespace App\CommissionCalculator\Reader;

class ExchangeRatesApiDataReader extends AbstractDataReader implements ExchangeRateDataReader
{
    protected string $resource;
    protected string $currency;

    public function __construct(string $resource, string $currency)
    {
        $this->resource = $resource;
        $this->currency = $currency;
    }

    public function getRate(): float
    {
        $data = $this->read();
        if (!array_key_exists('rates', $data)) {
            return 0.0;
        }

        return $data['rates'][$this->currency] ?? 0.0;
    }

    protected function getSourceUrl(): string
    {
        return $this->resource;
    }
}
