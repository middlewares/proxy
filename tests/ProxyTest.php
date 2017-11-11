<?php

namespace Middlewares\Tests;

use Middlewares\Proxy;
use Middlewares\Utils\Dispatcher;
use Middlewares\Utils\Factory;
use PHPUnit\Framework\TestCase;

class ProxyTest extends TestCase
{
    public function testProxy()
    {
        $request = Factory::createServerRequest([], 'GET', 'http://example.com/middlewares/psr15-middlewares');
        $target = Factory::createUri('https://github.com');

        $response = Dispatcher::run([
            new Proxy($target),
        ], $request);

        $html = (string) $response->getBody();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotFalse(stripos($html, 'middlewares/psr15-middlewares'));
    }
}
