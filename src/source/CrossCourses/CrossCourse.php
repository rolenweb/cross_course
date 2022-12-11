<?php

declare(strict_types=1);

namespace Source\CrossCourses;

class CrossCourse
{
    private CurrencyCodeEnum $currency;
    private int $amount;
    private float $value;

    /**
     * @param CurrencyCodeEnum $currency
     * @param int $amount
     * @param float $value
     */
    public function __construct(CurrencyCodeEnum $currency, int $amount, float $value)
    {
        $this->currency = $currency;
        $this->amount = $amount;
        $this->value = $value;
    }

    /**
     * @return CurrencyCodeEnum
     */
    public function getCurrency(): CurrencyCodeEnum
    {
        return $this->currency;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'currency' => $this->currency->value,
            'amount' => $this->amount,
            'value' => $this->value
        ];
    }
}
