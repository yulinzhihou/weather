<h1 align="center"> weather </h1>

<p align="center"> 🌈 基于高德地图接口的 PHP 天气信息组件包 🌈</p>

[![Tests](https://github.com/yulinzhihou/weather/actions/workflows/tests.yml/badge.svg)](https://github.com/yulinzhihou/weather/actions/workflows/tests.yml)

## 安装

```shell
$ composer require beans/weather -vvv
```

## 配置
在使用本扩展之前，你需要去 [高德开放平台](https://lbs.amap.com/dev/id/newuser) 注册账号，然后创建应用，获取应用的 API Key

## 使用

```php
use Beans\Weather\Weather;

$key = "XXXXXXXXXXXXX";

$weather = new Weather($key);

$weather->getWeather('长沙');

```

### 获取实时天气

```php

$weather->getWeather('长沙');

```

示例

```json
{
    "status": "1",
    "count": "2",
    "info": "OK",
    "infocode": "10000",
    "lives": [
        {
            "province": "湖南",
            "city": "长沙市",
            "adcode": "430100",
            "weather": "晴",
            "temperature": "18",
            "winddirection": "南",
            "windpower": "≤3",
            "humidity": "41",
            "reporttime": "2023-03-06 10:01:29",
            "temperature_float": "18.0",
            "humidity_float": "41.0"
        },
        {
            "province": "湖南",
            "city": "长沙县",
            "adcode": "430121",
            "weather": "晴",
            "temperature": "18",
            "winddirection": "北",
            "windpower": "≤3",
            "humidity": "41",
            "reporttime": "2023-03-06 10:01:29",
            "temperature_float": "18.0",
            "humidity_float": "41.0"
        }
    ]
}
```

### 获取近期天气预报

```php
$weather->getWeather('长沙','all');
```

示例
```json
{
    "status": "1",
    "count": "2",
    "info": "OK",
    "infocode": "10000",
    "forecasts": [
        {
            "city": "长沙市",
            "adcode": "430100",
            "province": "湖南",
            "reporttime": "2023-03-06 11:31:28",
            "casts": [
                {
                    "date": "2023-03-06",
                    "week": "1",
                    "dayweather": "晴",
                    "nightweather": "晴",
                    "daytemp": "26",
                    "nighttemp": "10",
                    "daywind": "东南",
                    "nightwind": "东南",
                    "daypower": "≤3",
                    "nightpower": "≤3",
                    "daytemp_float": "26.0",
                    "nighttemp_float": "10.0"
                },
                {
                    "date": "2023-03-07",
                    "week": "2",
                    "dayweather": "小雨",
                    "nightweather": "小雨",
                    "daytemp": "20",
                    "nighttemp": "15",
                    "daywind": "东",
                    "nightwind": "东",
                    "daypower": "≤3",
                    "nightpower": "≤3",
                    "daytemp_float": "20.0",
                    "nighttemp_float": "15.0"
                },
                {
                    "date": "2023-03-08",
                    "week": "3",
                    "dayweather": "小雨",
                    "nightweather": "多云",
                    "daytemp": "22",
                    "nighttemp": "13",
                    "daywind": "东南",
                    "nightwind": "东南",
                    "daypower": "≤3",
                    "nightpower": "≤3",
                    "daytemp_float": "22.0",
                    "nighttemp_float": "13.0"
                },
                {
                    "date": "2023-03-09",
                    "week": "4",
                    "dayweather": "晴",
                    "nightweather": "晴",
                    "daytemp": "24",
                    "nighttemp": "15",
                    "daywind": "东",
                    "nightwind": "东",
                    "daypower": "≤3",
                    "nightpower": "≤3",
                    "daytemp_float": "24.0",
                    "nighttemp_float": "15.0"
                }
            ]
        },
        {
            "city": "长沙县",
            "adcode": "430121",
            "province": "湖南",
            "reporttime": "2023-03-06 11:31:28",
            "casts": [
                {
                    "date": "2023-03-06",
                    "week": "1",
                    "dayweather": "晴",
                    "nightweather": "晴",
                    "daytemp": "26",
                    "nighttemp": "10",
                    "daywind": "东南",
                    "nightwind": "东南",
                    "daypower": "≤3",
                    "nightpower": "≤3",
                    "daytemp_float": "26.0",
                    "nighttemp_float": "10.0"
                },
                {
                    "date": "2023-03-07",
                    "week": "2",
                    "dayweather": "小雨",
                    "nightweather": "小雨",
                    "daytemp": "20",
                    "nighttemp": "15",
                    "daywind": "东",
                    "nightwind": "东",
                    "daypower": "≤3",
                    "nightpower": "≤3",
                    "daytemp_float": "20.0",
                    "nighttemp_float": "15.0"
                },
                {
                    "date": "2023-03-08",
                    "week": "3",
                    "dayweather": "小雨",
                    "nightweather": "多云",
                    "daytemp": "22",
                    "nighttemp": "13",
                    "daywind": "东南",
                    "nightwind": "东南",
                    "daypower": "≤3",
                    "nightpower": "≤3",
                    "daytemp_float": "22.0",
                    "nighttemp_float": "13.0"
                },
                {
                    "date": "2023-03-09",
                    "week": "4",
                    "dayweather": "晴",
                    "nightweather": "晴",
                    "daytemp": "24",
                    "nighttemp": "15",
                    "daywind": "东",
                    "nightwind": "东",
                    "daypower": "≤3",
                    "nightpower": "≤3",
                    "daytemp_float": "24.0",
                    "nighttemp_float": "15.0"
                }
            ]
        }
    ]
}
```

### 获取 XML 格式返回值
第三个参数为返回值类型，可选 `json` 与 `xml` ，默认 `json`
```php
$response = $weather->getWeather('长沙','all','xml');
```
示例
```xml
<?xml version="1.0" encoding="UTF-8"?>\n
<response>
	<status>1</status>
	<count>2</count>
	<info>OK</info>
	<infocode>10000</infocode>
	<lives type="list">
		<live>
			<province>\u6e56\u5357</province>
			<city>\u957f\u6c99\u5e02</city>
			<adcode>430100</adcode>
			<weather>\u6674</weather>
			<temperature>20</temperature>
			<winddirection>\u897f\u5357</winddirection>
			<windpower>\u22643</windpower>
			<humidity>36</humidity>
			<reporttime>2023-03-06 11:31:28</reporttime>
			<temperature_float>20.0</temperature_float>
			<humidity_float>36.0</humidity_float>
		</live>
		<live>
			<province>\u6e56\u5357</province>
			<city>\u957f\u6c99\u53bf</city>
			<adcode>430121</adcode>
			<weather>\u6674</weather>
			<temperature>20</temperature>
			<winddirection>\u5357</winddirection>
			<windpower>4</windpower>
			<humidity>36</humidity>
			<reporttime>2023-03-06 11:31:28</reporttime>
			<temperature_float>20.0</temperature_float>
			<humidity_float>36.0</humidity_float>
		</live>
	</lives>
</response>
```

### 参数说明
```php
array|string getWeather(string $city,string $type = 'base',string $format = 'json')
```

- `$city` - 城市名，比如："长沙"
- `$type` - 返回内容类型：`base`：返回实况天气 / `all`：返回天气预报
- `$format` - 输出的数据格式，默认为 `json` 格式，当 output 设置为 "`xml`" 时，输出的为 XML 格式的数据。


### 在 Laravel 中使用
在 Laravel 中使用也是同样的安装方式，配置写在 `config/services.php` 中：
```php
.
.
.

'weather'   => [
    'key' => env('WEATHER_API_KEY')
];
.
.
.

```
然后在 `.env` 中配置 `WEATHER_API_KEY` :

```.dotenv
WEATHER_API_KEY=XXXXXXXXXX
```

可以用两种方式来获取 `Beans\Weather\Weather` 实例：

**方法注入**
```php
.
.
.

public function edit(Weather $weather)
{
    $response = $weather->getWeather('长沙');
}
.
.
.
```

**服务名访问**

```php
public function edit()
{
    $response = app('weather')->getWeather('长沙');
}
```

## 参考
- [高德开放平台天气接口](https://lbs.amap.com/api/webservice/guide/api/weatherinfo/)

## 贡献

您可以通过以下三种方式之一做出贡献：

1. File bug reports using the [issue tracker](https://github.com/beans/weather/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/beans/weather/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable.

## License

MIT