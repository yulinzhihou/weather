<?php
declare(strict_types=1);

namespace Yulinzhihou\Weather;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Yulinzhihou\Weather\Exceptions\HttpException;
use Yulinzhihou\Weather\Exceptions\InvalidArgumentException;

/**
 * 天气
 */
class Weather
{


    /**
     * 高德应用KEY
     */
    protected string $key;

    /**
     * http 客户端参数
     * @var array
     */
    protected array $guzzleOptions = [];

    /**
     * @param $key
     */
    public function __construct($key)
    {
//        6a3a8eea4e86538e8269124cf4d1c809
        $this->key = $key;
    }

    /**
     * @param array $option
     * @return void
     */
    public function setGuzzleOptions(array $option)
    {
        $this->guzzleOptions = $option;
    }

    /**
     * 实例http
     * @return Client
     */
    public function getHttpClient():Client
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * 获取天气
     * @param string $type
     * @param string $format
     * @return string|array
     * @throws HttpException
     * @throws InvalidArgumentException
     * @throws HttpException|GuzzleException
     */
    public function getWeather($city,string $type = 'base', string $format = 'json'):string|array
    {
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo';

        if (!$city || !is_string($city)) {
            throw new InvalidArgumentException('Invalid city value type(string/int ): '.gettype($city));
        }

        if (!\in_array(\strtolower($type),['base','all'])) {
            throw new InvalidArgumentException('Invalid Type Value(base/all):'.$type);
        }

        if (!\in_array(\strtolower($format),['json','xml'])) {
            throw new InvalidArgumentException('Invalid response format: '.$format);
        }

        $query = array_filter([
            'key' => $this->key,
            'city'  => $city,
            'output' => $format,
            'extensions' => $type
        ]);
        try {
            $response = $this->getHttpClient()->get($url,[
                'query' => $query
            ])->getBody()->getContents();

            return 'json' == $format ? \json_decode($response,true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }

    }


}