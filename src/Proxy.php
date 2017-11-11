<?php
declare(strict_types = 1);

namespace Middlewares;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Stream;
use Interop\Http\Server\MiddlewareInterface;
use Interop\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

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
     */
    public function __construct(UriInterface $target)
    {
        $this->target = $target;
    }

    /**
     * Set the client
     */
    public function client(ClientInterface $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Set the client options
     */
    public function options(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Process a request and return a response.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
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
