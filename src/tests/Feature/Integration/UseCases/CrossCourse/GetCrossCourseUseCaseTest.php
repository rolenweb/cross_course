<?php

declare(strict_types=1);

namespace Test\Feature\Integration\UseCases\CrossCourse;

use App\UseCases\CrossCourse\GetCrossCourseCommand;
use App\UseCases\CrossCourse\GetCrossCourseUseCase;
use DateTimeImmutable;
use Source\CrossCourses\CurrencyCodeEnum;
use Tests\TestCase;

class GetCrossCourseUseCaseTest extends TestCase
{
    public function testCanGetCrossCourseUsingDefaultBaseCurrency()
    {
        /* @var GetCrossCourseUseCase $useCase */
        $useCase = $this->app->make(GetCrossCourseUseCase::class);
        $command = new GetCrossCourseCommand(
            new DateTimeImmutable('2022-12-09'),
            CurrencyCodeEnum::AUD,
            CurrencyCodeEnum::RUB
        );
        $course = $useCase->handle($command);

        $this->assertEquals(CurrencyCodeEnum::AUD, $course['currency']);
        $this->assertEquals(CurrencyCodeEnum::RUB, $course['baseCurrency']);
        $this->assertEquals(42.0235, $course['value']);
        $this->assertEquals(-0.0941, round($course['change'], 4));
    }

    public function testCanGetCrossCourseNotUsingDefaultBaseCurrency()
    {
        /* @var GetCrossCourseUseCase $useCase */
        $useCase = $this->app->make(GetCrossCourseUseCase::class);
        $command = new GetCrossCourseCommand(
            new DateTimeImmutable('2022-12-09'),
            CurrencyCodeEnum::EUR,
            CurrencyCodeEnum::USD
        );
        $course = $useCase->handle($command);

        $this->assertEquals(CurrencyCodeEnum::EUR, $course['currency']);
        $this->assertEquals(CurrencyCodeEnum::USD, $course['baseCurrency']);
        $this->assertEquals(0.9527, round($course['value'], 4));
        $this->assertEquals(-0.0024, round($course['change'], 4));
    }
}
