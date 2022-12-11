<?php

declare(strict_types=1);

namespace Test\Feature\Integration\Source\CrossCourse\Crb;

use DateTimeImmutable;
use Source\CrossCourses\Crb\Crb;
use Source\CrossCourses\CurrencyCodeEnum;
use Source\CrossCourses\Dto;
use Tests\TestCase;

class GetCrossCourseFromCrbTest extends TestCase
{
    public function testCanGetCrossCourseFromCrbByDay()
    {
        $crb = new Crb();
        $date = new DateTimeImmutable('2022-12-09');
        $courses = $crb->get($date);
        $this->assertEquals(CurrencyCodeEnum::AUD, $courses->getCrossCourses()[0]->getCurrency());
        $this->assertEquals(1, $courses->getCrossCourses()[0]->getAmount());
        $this->assertEquals(42.0235, $courses->getCrossCourses()[0]->getValue());
        $this->assertEquals($date, $courses->getDate());
    }
}
