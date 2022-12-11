<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\UseCases\CrossCourse\GetCrossCourseCommand;
use App\UseCases\CrossCourse\GetCrossCourseUseCase;
use DateTimeImmutable;
use Illuminate\Http\JsonResponse;
use Source\CrossCourses\CurrencyCodeEnum;

class CrossCourseController extends Controller
{
    private GetCrossCourseUseCase $getCrossCourseUseCase;

    /**
     * @param GetCrossCourseUseCase $getCrossCourseUseCase
     */
    public function __construct(GetCrossCourseUseCase $getCrossCourseUseCase)
    {
        $this->getCrossCourseUseCase = $getCrossCourseUseCase;
    }

    /**
     * @param string $day
     * @param string $currency
     * @param string|null $baseCurrency
     * @return JsonResponse
     * @throws \Exception
     */
    public function index(string $day, string $currency, string $baseCurrency = null): JsonResponse
    {
        $command = new GetCrossCourseCommand(
            new DateTimeImmutable($day),
            CurrencyCodeEnum::from($currency),
            $baseCurrency ? CurrencyCodeEnum::from($baseCurrency) : CurrencyCodeEnum::from(config('cross_course.base_currency'))
        );
        return response()->json($this->getCrossCourseUseCase->handle($command));
    }
}
