<?php
declare(strict_types = 1);

namespace Middlewares\Tests;

use GuzzleHttp\Client;
use Middlewares\Proxy;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;
use PHPUnit\Framework\TestCase;

class ProxyTest extends TestCase
{
    public function testProxy()
    {
        $response = Dispatcher::run(
            [
                new Proxy(Factory::createUri('https://github.com')),
            ],
            Factory::createServerRequest([], 'GET', 'http://example.com/middlewares/psr15-middlewares')
        );

        $html = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotFalse(stripos($html, 'middlewares/psr15-middlewares'));
    }

    public function testOptionsAndClient()
    {
        $received = false;
        $response = Dispatcher::run(
            [
                (new Proxy(Factory::createUri('https://github.com')))
                    ->client(new Client())
                    ->options([
                        'on_headers' => function () use (&$received) {
                            $received = true;
                        },
                    ]),
            ],
            Factory::createServerRequest([], 'GET', 'http://example.com/middlewares/psr15-middlewares')
        );

        $html = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotFalse(stripos($html, 'middlewares/psr15-middlewares'));
        $this->assertTrue($received);
    }

    public function testError()
    {
        $response = Dispatcher::run(
            [
                new Proxy(Factory::createUri('http://not-found.com')),
            ],
            Factory::createServerRequest([], 'GET', 'http://example.com/middlewares/psr15-middlewares')
        );

        $html = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testTargetPath()
    {
        $response = Dispatcher::run(
            [
                new Proxy(Factory::createUri('https://github.com/middlewares')),
            ],
            Factory::createServerRequest([], 'GET', 'http://example.com/psr15-middlewares')
        );

        $html = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotFalse(stripos($html, 'middlewares/psr15-middlewares'));
    }
}
