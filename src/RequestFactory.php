<?php
namespace DevOp\Core\Http;

use DevOp\Core\Http\Request;
use Psr\Http\Message\RequestFactoryInterface;

class RequestFactory implements RequestFactoryInterface
{

    /**
     * 
     * @param string $method
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @return Request
     * @throws \InvalidArgumentException
     */
    public function createRequest(string $method, $uri): \Psr\Http\Message\RequestInterface
    {

        if (is_string($uri)) {
            $uri = (new UriFactory())->createUri($uri);
        }

        if (!$uri instanceof \Psr\Http\Message\UriInterface) {
            throw new \InvalidArgumentException('URI must be a instance of ' . \Psr\Http\Message\UriInterface::class);
        }

        $body = (new StreamFactory())->createStream('');

        return new Request($method, $uri, [], $body);
    }
}
