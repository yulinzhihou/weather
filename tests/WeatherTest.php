<?php

/*
 * This file is part of the beans/weather.
 *
 * (c) yulinzhihou <yulinzhihou@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Beans\Weather\Tests;

use Beans\Weather\Exceptions\HttpException;
use Beans\Weather\Exceptions\InvalidArgumentException;
use Beans\Weather\Weather;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mockery\Matcher\AnyArgs;
use PHPUnit\Framework\TestCase;

class WeatherTest extends TestCase
{
    public function testGetWeatherWithInvalidType()
    {
        $w = new Weather('mock-key');

        $this->expectException(InvalidArgumentException::class);

        $this->expectExceptionMessage('Invalid type value(live / forecast): foo');

        $w->getWeather('深圳', 'foo');

        $this->fail('Fail to assert getWeather throw exception with invalid argument.');
    }

    public function testGetWeatherWithInvalidFormat()
    {
        $w = new Weather('mock-key');

        $this->expectException(InvalidArgumentException::class);

        $this->expectExceptionMessage('Invalid response format: array');

        $w->getWeather('长沙', 'base', 'array');

        $this->fail('Fail to assert getWeather throw exception with invalid argument.');
    }

    public function testGetWeather()
    {
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';

        $query = [
            'key' => 'mock-key',
            'city' => '长沙',
            'output' => 'json',
            'extensions' => 'base',
        ];

        $queryXml = [
            'key' => 'mock-key',
            'city' => '长沙',
            'output' => 'xml',
            'extensions' => 'base',
        ];

        // json
        $response = new Response(200, [], '{"success": true}');

        $client = \Mockery::mock(Client::class);

        $client->allows()->get($url, ['query' => $query])->andReturn($response);

        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();

        $w->allows()->getHttpClient()->andReturn($client);

        $this->assertSame(['success' => true], $w->getWeather('长沙'), 'live', 'json');

        // xml
        $response = new Response(200, [], '<hello>content</hello>');

        $client = \Mockery::mock(Client::class);

        $client->allows()->get($url, ['query' => $queryXml])->andReturn($response);

        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();

        $w->allows()->getHttpClient()->andReturn($client);

        $this->assertSame('<hello>content</hello>', $w->getWeather('长沙', 'live', 'xml'));
    }

    public function testGetWeatherWithGuzzleRuntimeException()
    {
        $client = \Mockery::mock(Client::class);

        $client->allows()->get(new AnyArgs())->andThrow(new \Exception('request timeout'));

        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();

        $w->allows()->getHttpClient()->andReturn($client);

        $this->expectException(HttpException::class);

        $this->expectExceptionMessage('request timeout');

        $w->getWeather('长沙');
    }

    public function testGetHttpClient()
    {
        $w = new Weather('mock-key');

        $this->assertInstanceOf(ClientInterface::class, $w->getHttpClient());
    }

    public function testGuzzleOptions()
    {
        $w = new Weather('mock-key');

        $this->assertNull($w->getHttpClient()->getConfig('timeout'));

        $w->setGuzzleOptions(['timeout' => 5000]);

        $this->assertSame(5000, $w->getHttpClient()->getConfig('timeout'));
    }

    public function testGetLiveWeather()
    {
        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();

        $w->expects()->getWeather('长沙', 'live', 'json')->andReturn(['success' => true]);

        $this->assertSame(['success' => true], $w->getLiveWeather('长沙'));
    }

    public function testGetForecastWeather()
    {
        $w = \Mockery::mock(Weather::class, ['mock-key'])->makePartial();

        $w->expects()->getWeather('长沙', 'forecast', 'json')->andReturn(['success' => true]);

        $this->assertSame(['success' => true], $w->getForecastWeather('长沙'));
    }
}
