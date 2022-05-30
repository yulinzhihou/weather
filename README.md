<h1 align="center"> weather </h1>

<p align="center"> A weather SDK for Amap.</p>


[![Tests](https://github.com/yulinzhihou/weather/actions/workflows/test.yml/badge.svg)](https://github.com/yulinzhihou/weather/actions/workflows/test.yml)

## 安装


```shell
$ composer require yulinzhihou/weather -vvv
```

## 配置

在使用本扩展之前，你需要去 [高德开放平台](https://lbs.amap.com/dev/id/newuser) 注册账号，然后创建应用，获取应用的 API Key。

## 使用

```php
use Overtrue\Weather\Weather;

$key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

$weather = new Weather($key);

$response = $weather->getWeather('长沙');
```


## 贡献

您可以通过以下三种方式之一作出贡献：

1. 文件BUG使用 [issue tracker](https://github.com/yulinzhihou/weather/issues).
2. 回答问题或修复[issue tracker](https://github.com/yulinzhihou/weather/issues).
3. 提供新功能或更新wiki。

- 代码贡献过程不需要很正式。您只需要确保遵循PSR-0、PSR-1和PSR-2编码准则。任何新的代码贡献都必须附带单元测试（如适用）。

## License

MIT