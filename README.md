# middlewares/proxy

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
![Testing][ico-ga]
[![Total Downloads][ico-downloads]][link-downloads]

Middleware to create a http proxy using [Guzzle](https://github.com/guzzle/guzzle).

## Requirements

* PHP >= 7.2
* A [PSR-7 http library](https://github.com/middlewares/awesome-psr15-middlewares#psr-7-implementations)
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

## Usage

You need a `Psr\Http\Message\UriInterface` with the target of the proxy.

```php
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;

$target = Factory::createUri('http://api.example.com');

Dispatcher::run([
	new Middlewares\Proxy($target)
]);
```

### client

Instance of the client used to execute the requests. If it's not provided, an instance of `GuzzleHttp\Client` is created automatically.

```php
$target = Factory::createUri('http://api.example.com');
$client = new Client();

$proxy = (new Middlewares\Proxy($target))->client($client);
```

### options

Options passed to the guzzle client. [See the guzzle documentation for more information](http://docs.guzzlephp.org/en/latest/request-options.html)

---

Please see [CHANGELOG](CHANGELOG.md) for more information about recent changes and [CONTRIBUTING](CONTRIBUTING.md) for contributing details.

The MIT License (MIT). Please see [LICENSE](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/middlewares/proxy.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-ga]: https://github.com/middlewares/proxy/workflows/testing/badge.svg
[ico-downloads]: https://img.shields.io/packagist/dt/middlewares/proxy.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/middlewares/proxy
[link-scrutinizer]: https://scrutinizer-ci.com/g/middlewares/proxy
[link-downloads]: https://packagist.org/packages/middlewares/proxy
