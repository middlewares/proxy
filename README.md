# middlewares/proxy

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-scrutinizer]][link-scrutinizer]
[![Total Downloads][ico-downloads]][link-downloads]
[![SensioLabs Insight][ico-sensiolabs]][link-sensiolabs]

Middleware to create a http proxy using [Guzzle](https://github.com/guzzle/guzzle).

## Requirements

* PHP >= 5.6
* A [PSR-7](https://packagist.org/providers/psr/http-message-implementation) http mesage implementation ([Diactoros](https://github.com/zendframework/zend-diactoros), [Guzzle](https://github.com/guzzle/psr7), [Slim](https://github.com/slimphp/Slim), etc...)
* A [PSR-15 middleware dispatcher](https://github.com/middlewares/awesome-psr15-middlewares#dispatcher)

## Installation

This package is installable and autoloadable via Composer as [middlewares/proxy](https://packagist.org/packages/middlewares/proxy).

```sh
composer require middlewares/proxy
```

## Example

```php
$target = new Uri('http://api.example.com');

$dispatcher = new Dispatcher([
	new Middlewares\Proxy($target)
]);

$response = $dispatcher->dispatch(new ServerRequest());
```

## Options

#### `__construct(Psr\Http\Message\UriInterface $uri)`

The target of the proxy.

#### `client(GuzzleHttp\ClientInterface $client)`

Instance of the client used to execute the requests. If it's not provided, an instance of `GuzzleHttp\Client` is created automatically.

#### `options(array $options)`

Options passed to the guzzle client. [See the guzzle documentation for more information](http://docs.guzzlephp.org/en/latest/request-options.html)

---

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes and [CONTRIBUTING](CONTRIBUTING.md) for contributing details.

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/middlewares/proxy.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/middlewares/proxy/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/g/middlewares/proxy.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/middlewares/proxy.svg?style=flat-square
[ico-sensiolabs]: https://img.shields.io/sensiolabs/i/{project_id_here}.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/middlewares/proxy
[link-travis]: https://travis-ci.org/middlewares/proxy
[link-scrutinizer]: https://scrutinizer-ci.com/g/middlewares/proxy
[link-downloads]: https://packagist.org/packages/middlewares/proxy
[link-sensiolabs]: https://insight.sensiolabs.com/projects/{project_id_here}
