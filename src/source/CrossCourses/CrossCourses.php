<?php

declare(strict_types=1);

namespace Source\CrossCourses;

use DateTimeImmutable;

class CrossCourses
{
    private DateTimeImmutable $date;

    /**
     * @var CrossCourse[]
     */
    private array $crossCourses;

    /**
     * @param DateTimeImmutable $date
     * @param CrossCourse[] $crossCourses
     */
    public function __construct(DateTimeImmutable $date, array $crossCourses)
    {
        $this->date = $date;
        $this->crossCourses = $crossCourses;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return array
     */
    public function getCrossCourses(): array
    {
        return $this->crossCourses;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'date' => $this->date->format('d-m-y'),
            'crossCourses' => array_map(fn($item) => $item->toArray(), $this->crossCourses)
        ];
    }

    /**
     * @return array
     */
    public function toArrayIndexByCurrency(): array
    {
        $crossCourses = array_map(fn($item) => $item->toArray(), $this->crossCourses);
        $indexedArray = [];
        foreach ($crossCourses as $crossCourse) {
            $indexedArray[$crossCourse['currency']] = $crossCourse;
        }
        return [
            'date' => $this->date->format('d-m-y'),
            'crossCourses' => $indexedArray
        ];
    }
}
