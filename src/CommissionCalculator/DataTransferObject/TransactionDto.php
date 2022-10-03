<?php

namespace App\CommissionCalculator\DataTransferObject;

class TransactionDto
{
    protected string $bin;
    protected float $amount;
    protected string $currency;
    protected float $commission;
    protected string $country;

    public function __construct(
        string $bin,
        float $amount,
        string $currency
    ) {
        $this->bin = $bin;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->commission = $amount;
    }

    /**
     * @return string
     */
    public function getBin(): string
    {
        return $this->bin;
    }

    /**
     * @param string $bin
     */
    public function setBin(string $bin): void
    {
        $this->bin = $bin;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getCommission(): float
    {
        return $this->commission;
    }

    /**
     * @param float $commission
     */
    public function setCommission(float $commission): void
    {
        $this->commission = $commission;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }
}
