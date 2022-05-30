<?php

namespace Yulinzhihou\Weather\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use Mockery\Matcher\AnyArgs;
use PHPUnit\Framework\TestCase;
use Yulinzhihou\Weather\Exceptions\HttpException;
use Yulinzhihou\Weather\Exceptions\InvalidArgumentException;
use Yulinzhihou\Weather\Weather;

class WeatherTest extends TestCase
{
    public function testGetWeatherWithInvalidType()
    {
        $w = new Weather('mock-key');
        $test = 'test';

        $this->expectException(InvalidArgumentException::class);

        $this->expectExceptionMessage('Invalid Type Value(base/all):'.$test);

        $w->getWeather('长沙',$test);

        $this->fail('Fail to use Type value test.');
    }

    public function testGetWeatherWithInvalidCity()
    {
        $w = new Weather('mock-key');

        $this->expectException(InvalidArgumentException::class);

        $this->expectExceptionMessage('Invalid city value type(string/int ): '.gettype(1.234));

        $w->getWeather(1.234);

        $this->fail('Fail to use invalid city value 1.234');

    }

    public function testGetWeatherWithInvalidFormat()
    {
        $w = new Weather('mock-key');

        $this->expectException(InvalidArgumentException::class);

        $this->expectExceptionMessage('Invalid response format: array');

        $w->getWeather('长沙','base','array');

        $this->fail('Fail to use invalid response format (json/xml): array');
    }

    public function testGetWeather()
    {
        //json
        $response = new Response(200,[],'{"success":true}');

        $client = \Mockery::mock(Client::class);

        $client->allows()->get('https://restapi.amap.com/v3/weather/weatherInfo',[
            'query' => [
                'key'   => 'mock-key',
                'city'  => '长沙',
                'output' => 'json',
                'extensions'   => 'base'
            ]
        ])->andReturn($response);

        $w = \Mockery::mock(Weather::class,['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);
        $this->assertSame(['success'=>true],$w->getWeather('长沙'));

        //xml
        $responseXML = new Response(200,[],'<hello>content</hello>');

        $client = \Mockery::mock(Client::class);

        $client->allows()->get('https://restapi.amap.com/v3/weather/weatherInfo',[
            'query' => [
                'key'   => 'mock-key',
                'output'  => 'xml',
                'city'  =>  '长沙',
                'extensions' => 'all'
            ]
        ])->andReturn($responseXML);
        $w = \Mockery::mock(Weather::class,['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        $this->assertSame('<hello>content</hello>',$w->getWeather('长沙','all','xml'));
    }

    public function testGetWeatherWithGuzzleRuntimeException()
    {
        $client = \Mockery::mock(Client::class);
        $client->allows()->get(new AnyArgs())->andThrow(new \Exception('request timeout'));

        $w = \Mockery::mock(Weather::class,['mock-key'])->makePartial();
        $w->allows()->getHttpClient()->andReturn($client);

        $this->expectException(HttpException::class);

        $this->expectExceptionMessage('request timeout');

        $w->getWeather('长沙');
    }

    public function testGetHttpClient()
    {
        $w = new Weather('mock-key');

        $this->assertInstanceOf(ClientInterface::class,$w->getHttpClient());

    }

    public function testSetGuzzleOptions()
    {
        $w = new Weather('mock-key');

        $this->assertNull($w->getHttpClient()->getConfig('timeout'));

        $w->setGuzzleOptions(['timeout'=>5000]);

        $this->assertSame(5000,$w->getHttpClient()->getConfig('timeout'));
    }

    public function testGetLiveWeather()
    {
        $w = \Mockery::mock(Weather::class,['mock-key'])->makePartial();

        $w->expects()->getWeather('长沙','base','json')->andReturn(['success'=>true]);

        $this->assertSame(['success'=>true],$w->getLiveWeather('长沙'));
    }

    public function testGetForecastsWeather()
    {
        $w = \Mockery::mock(Weather::class,['mock-key'])->makePartial();

        $w->expects()->getWeather('长沙','all','json')->andReturn(['success'=>true]);

        $this->assertSame(['success'=>true],$w->getForecastsWeather('长沙'));
    }

}