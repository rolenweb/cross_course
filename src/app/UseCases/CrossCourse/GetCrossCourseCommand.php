<?php

declare(strict_types=1);

namespace App\UseCases\CrossCourse;

use DateTimeImmutable;
use Source\CrossCourses\CurrencyCodeEnum;

class GetCrossCourseCommand
{
    private DateTimeImmutable $date;
    private CurrencyCodeEnum $currency;
    private CurrencyCodeEnum $baseCurrency;

    /**
     * @param DateTimeImmutable $date
     * @param CurrencyCodeEnum $currency
     * @param CurrencyCodeEnum $baseCurrency
     */
    public function __construct(DateTimeImmutable $date, CurrencyCodeEnum $currency, CurrencyCodeEnum $baseCurrency)
    {
        $this->date = $date;
        $this->currency = $currency;
        $this->baseCurrency = $baseCurrency;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return CurrencyCodeEnum
     */
    public function getCurrency(): CurrencyCodeEnum
    {
        return $this->currency;
    }

    /**
     * @return CurrencyCodeEnum
     */
    public function getBaseCurrency(): CurrencyCodeEnum
    {
        return $this->baseCurrency;
    }
}
