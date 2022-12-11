<?php

declare(strict_types=1);

namespace App\UseCases\CrossCourse;


use DateInterval;
use DateTimeImmutable;
use Illuminate\Support\Facades\Cache;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Source\CrossCourses\CrossCourseInterface;
use Source\CrossCourses\CurrencyCodeEnum;

class GetCrossCourseUseCase
{
    private CrossCourseInterface $crossCourseProvider;
    public function __construct()
    {
        $provider = config('cross_course.provider');
        $handler = config('cross_course.providers.' . $provider . '.handler');
        $this->crossCourseProvider = new $handler;
    }

    public function handle(GetCrossCourseCommand $command)
    {
        $date = $command->getDate();
        $crossCourses = $this->getCrossCourses($date);
        $crossCoursesYesterday = $this->getCrossCourses($date->sub(new DateInterval('P1D')));
        if ($command->getBaseCurrency() === CurrencyCodeEnum::from(config('cross_course.base_currency'))) {
            return [
                'currency' => $command->getCurrency(),
                'baseCurrency' => $command->getBaseCurrency(),
                'date' => $command->getDate(),
                'value' => $crossCourses['crossCourses'][$command->getCurrency()->value]['value'] / $crossCourses['crossCourses'][$command->getCurrency()->value]['amount'],
                'change' =>  $crossCourses['crossCourses'][$command->getCurrency()->value]['value'] / $crossCourses['crossCourses'][$command->getCurrency()->value]['amount'] - $crossCoursesYesterday['crossCourses'][$command->getCurrency()->value]['value'] / $crossCoursesYesterday['crossCourses'][$command->getCurrency()->value]['amount']
            ];
        }
        $courseToDefaultBaseCurrency = $crossCourses['crossCourses'][$command->getCurrency()->value]['value'] / $crossCourses['crossCourses'][$command->getCurrency()->value]['amount'];
        $courseBaseCurrencyToDefaultBaseCurrency = $crossCourses['crossCourses'][$command->getBaseCurrency()->value]['value'] / $crossCourses['crossCourses'][$command->getBaseCurrency()->value]['amount'];
        $course =  $courseBaseCurrencyToDefaultBaseCurrency / $courseToDefaultBaseCurrency;

        $courseToDefaultBaseCurrencyYesterday = $crossCoursesYesterday['crossCourses'][$command->getCurrency()->value]['value'] / $crossCoursesYesterday['crossCourses'][$command->getCurrency()->value]['amount'];
        $courseBaseCurrencyToDefaultBaseCurrencyYesterday = $crossCoursesYesterday['crossCourses'][$command->getBaseCurrency()->value]['value'] / $crossCoursesYesterday['crossCourses'][$command->getBaseCurrency()->value]['amount'];
        $courseYesterday = $courseBaseCurrencyToDefaultBaseCurrencyYesterday / $courseToDefaultBaseCurrencyYesterday;

        return [
            'currency' => $command->getCurrency(),
            'baseCurrency' => $command->getBaseCurrency(),
            'date' => $command->getDate(),
            'value' => $course,
            'change' => $course - $courseYesterday
        ];
    }

    /**
     * @param DateTimeImmutable $date
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getCrossCourses(DateTimeImmutable $date): array
    {
        return Cache::tags(['courses'])->rememberForever(
            $date->format('d-m-y'),
            function () use ($date) {
                return $this->crossCourseProvider->get($date)->toArrayIndexByCurrency();
            }
        );
    }
}
