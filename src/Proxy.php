<?php

namespace Middlewares;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Exception\RequestException;

class Proxy implements MiddlewareInterface
{
    /**
     * @var UriInterface
     */
    private $target;

    /**
     * @var ClientInterface|null
     */
    private $client;

    /**
     * @var array
     */
    private $options = [];

    /**
     * Set the proxy uri target
     *
     * @param UriInterface $target
     */
    public function __construct(UriInterface $target)
    {
        $this->target = $target;
    }

    /**
     * Set the client
     *
     * @param ClientInterface $client
     *
     * @return self
     */
    public function client(ClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Set the client options
     *
     * @param array $options
     *
     * @return self
     */
    public function options(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Process a request and return a response.
     *
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        if (!$this->client) {
            $this->client = new Client();
        }

        $target = $this->target;
        $uri = $request->getUri()
            ->withScheme($target->getScheme())
            ->withHost($target->getHost())
            ->withPort($target->getPort());

        if ($target->getPath()) {
            $uri = $uri->withPath(str_replace('//', '/', $target->getPath().'/'.$uri->getPath()));
        }

        $request = $request->withUri($uri);

        try {
            $response = $this->client->send($request, $this->options);
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
        }

        $response = $response->withBody(new Stream($response->getBody()->detach()));

        return $response;
    }
}
