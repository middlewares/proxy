<?php
declare(strict_types = 1);

namespace Middlewares\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Middlewares\Proxy;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;
use PHPUnit\Framework\TestCase;

class ProxyTest extends TestCase
{
    public function testProxy(): void
    {
        $response = Dispatcher::run(
            [
                new Proxy(Factory::createUri('https://github.com')),
            ],
            Factory::createServerRequest('GET', 'http://example.com/middlewares/psr15-middlewares')
        );

        $html = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotFalse(stripos($html, 'middlewares/psr15-middlewares'));
    }

    public function testOptionsAndClient(): void
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
            Factory::createServerRequest('GET', 'http://example.com/middlewares/psr15-middlewares')
        );

        $html = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotFalse(stripos($html, 'middlewares/psr15-middlewares'));
        $this->assertTrue($received);
    }

    public function testError(): void
    {
        $response = Dispatcher::run(
            [
                new Proxy(Factory::createUri('https://github.com/404')),
            ],
            Factory::createServerRequest('GET', 'http://example.com/middlewares/psr15-middlewares')
        );

        $html = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testTargetPath(): void
    {
        $response = Dispatcher::run(
            [
                new Proxy(Factory::createUri('https://github.com/middlewares')),
            ],
            Factory::createServerRequest('GET', 'http://example.com/psr15-middlewares')
        );

        $html = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotFalse(stripos($html, 'middlewares/psr15-middlewares'));
    }

    /**
     * If Guzzle throws an exception that does not have a response, we expect it to be
     * re-thrown.
     *
     * @see https://github.com/middlewares/proxy/issues/1
     */
    public function testRethrowsExceptionIfNoResponse(): void
    {
        $client = $this->createMock(Client::class);
        $request = Factory::createServerRequest('GET', 'http://example.com/middlewares/psr15-middlewares');

        $client->method('send')->willThrowException(new ConnectException('Error', $request));

        $this->expectException(ConnectException::class);

        Dispatcher::run(
            [
                (new Proxy(Factory::createUri('https://github.com')))->client($client),
            ],
            $request
        );
    }
}
