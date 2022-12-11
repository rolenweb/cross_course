<?php

namespace Source\CrossCourses;

use DateTimeImmutable;

interface CrossCourseInterface
{
    public function get(DateTimeImmutable $date): CrossCourses;
}
