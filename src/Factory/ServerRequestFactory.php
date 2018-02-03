<?php
namespace DevOp\Core\Http\Factory;

use DevOp\Core\Http\ServerRequest;
use Psr\Http\Message\UriInterface;
use Interop\Http\Factory\ServerRequestFactoryInterface;

class ServerRequestFactory implements ServerRequestFactoryInterface
{

    /**
     * @param string $method
     * @param UriInterface $uri
     * @return ServerRequest
     */
    public function createServerRequest($method, UriInterface $uri = null)
    {
        if (!$uri instanceof UriInterface) {
            $uri = new Uri($uri);
        }

        return new ServerRequest($method, $uri);
    }

    /**
     * @param array $server
     * @return ServerRequest
     */
    public function createServerRequestFromArray(array $server)
    {
        $method = $server['REQUEST_METHOD'] ?: 'GET';
        $uri = (new UriFactory())->createUri('');
        $body = (new StreamFactory())->createStreamFromFile('php://temp', 'r+');

        return new ServerRequest($method, $uri, $server, $body, '1.1');
    }
}