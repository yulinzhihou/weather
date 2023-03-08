<?php

/*
 * This file is part of the beans/weather.
 *
 * (c) yulinzhihou <yulinzhihou@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Beans\Weather;

use Beans\Weather\Exceptions\HttpException;
use Beans\Weather\Exceptions\InvalidArgumentException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * 根据城市获取天气.
 */
class Weather
{
    /**
     * 高德地图app key
     * https://lbs.amap.com/dev/id/newuser.
     */
    protected string $key;

    /**
     * HTTP 请求类参数.
     */
    protected array $guzzleOptions = [];

    /**
     * 构造方法.
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * 初始化 http 客户端.
     */
    public function getHttpClient(): Client
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * 配置 http 参数.
     */
    public function setGuzzleOptions(array $options): array
    {
        return $this->guzzleOptions = $options;
    }

    /**
     * 根据城市名获取天气.
     *
     * @throws GuzzleException
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function getWeather(string $city, string $type = 'live', string $format = 'json'): array|string
    {
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';

        $types = [
            'live' => 'base',
            'forecast' => 'all',
        ];

        if (!\in_array(\strtolower($format), ['json', 'xml'])) {
            throw new InvalidArgumentException('Invalid response format: '.$format);
        }

        if (!\in_array(\strtolower($type), array_keys($types))) {
            throw new InvalidArgumentException('Invalid type value(live / forecast): '.$type);
        }

        $query = [
            'key' => $this->key,
            'city' => $city,
            'output' => $format,
            'extensions' => $types[$type],
        ];

        try {
            $response = $this->getHttpClient()->get($url, ['query' => $query])->getBody()->getContents();

            return 'json' === $format ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 获取实时天气.
     */
    public function getLiveWeather(string $city, string $format = 'json'): array|string
    {
        return $this->getWeather($city, 'live', $format);
    }

    public function getForecastWeather(string $city, string $format = 'json'): array|string
    {
        return $this->getWeather($city, 'forecast', $format);
    }
}
