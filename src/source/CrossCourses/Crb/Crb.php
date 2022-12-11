<?php

declare(strict_types=1);

namespace Source\CrossCourses\Crb;

use DateTimeImmutable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Source\CrossCourses\CrossCourse;
use Source\CrossCourses\CrossCourseInterface;
use Source\CrossCourses\CrossCourses;
use Source\CrossCourses\CurrencyCodeEnum;
use Symfony\Component\DomCrawler\Crawler;

class Crb implements CrossCourseInterface
{
    private string $url;

    public function __construct()
    {
        $this->url = config('cross_course.providers.crb.source.url');
    }

    /**
     * @param DateTimeImmutable $date
     * @return CrossCourses
     * @throws RequestException
     */
    public function get(DateTimeImmutable $date): CrossCourses
    {
        $content = $this->getContent($this->url . $date->format('d.m.Y'));
        $crawler = new Crawler($content);
        $data = $crawler
            ->filter('.table-wrapper > .table > table.data tr')
            ->each(function (Crawler $tr) {
                $trData = $tr->filter('td')->each(function ($td) {
                    return $td->text();
                });
                return $trData;
            });

        return new CrossCourses(
            $date,
            array_values(
                array_map(fn($item) => new CrossCourse(
                    CurrencyCodeEnum::from($item[1]),
                    (int) $item[2],
                    (float) str_replace(',','.', $item[4])
                ),
                array_filter($data, fn($item) => $item))
            )
        );
    }

    /**
     * @param string $url
     * @return string
     * @throws RequestException
     */
    private function getContent(string $url): string
    {
        return Http::get($url)
            ->throw()
            ->body();
    }
}
