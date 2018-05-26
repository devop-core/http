<?php
namespace DevOp\Core\Http;

use DevOp\Core\Http\Request;
use Interop\Http\Factory\RequestFactoryInterface;

class RequestFactory implements RequestFactoryInterface
{

    /**
     * @param string $method
     * @param string|\Psr\Http\Message\UriInterface $uri
     * @return Request
     * @throws \InvalidArgumentException
     */
    public function createRequest($method, $uri)
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
