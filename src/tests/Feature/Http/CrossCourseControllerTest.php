<?php

declare(strict_types=1);

namespace Tests\Feature\Http;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CrossCourseControllerTest extends TestCase
{
    public function testCanGetCrossCourseUsingDefaultBaseCurrency()
    {
        $response = $this->getJson('api/09.12.2022/USD/');
        $response
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) =>
            $json
                ->hasAll([
                'currency', 'baseCurrency', 'date', 'value', 'change'
                ])
        );

        $data = $response->json();

        $this->assertEquals('USD', $data['currency']);
        $this->assertEquals('RUB', $data['baseCurrency']);
        $this->assertEquals(new \DateTimeImmutable('2022-12-09'), new \DateTimeImmutable($data['date']['date']));
        $this->assertEquals(62.5722, round($data['value'], 4));
        $this->assertEquals(-0.3650, round($data['change'], 4));
    }

    public function testCanGetCrossCourseNotUsingDefaultBaseCurrency()
    {
        $response = $this->getJson('api/09.12.2022/EUR/USD');
        $response
            ->assertOk()
            ->assertJson(fn(AssertableJson $json) =>
            $json
                ->hasAll([
                'currency', 'baseCurrency', 'date', 'value', 'change'
                ])
        );
        $data = $response->json();

        $this->assertEquals('EUR', $data['currency']);
        $this->assertEquals('USD', $data['baseCurrency']);
        $this->assertEquals(new \DateTimeImmutable('2022-12-09'), new \DateTimeImmutable($data['date']['date']));
        $this->assertEquals(0.9527, round($data['value'], 4));
        $this->assertEquals(-0.0024, round($data['change'], 4));
    }
}
