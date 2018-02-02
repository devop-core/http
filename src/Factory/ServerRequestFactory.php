<?php
namespace DevOp\Core\Http\Factory;

use DevOp\Core\Http\Uri;
use DevOp\Core\Http\Stream;
use DevOp\Core\Http\ServerRequest;
use Psr\Http\Message\UriInterface;
use Interop\Http\Factory\ServerRequestFactoryInterface;

class ServerRequestFactory implements ServerRequestFactoryInterface
{

    public function createServerRequest($method, UriInterface $uri = null)
    {
        if (!$uri instanceof UriInterface) {
            $uri = new Uri($uri);
        }

        return new ServerRequest($method, $uri);
    }

    public function createServerRequestFromArray(array $server)
    {
        $method = $server['REQUEST_METHOD'] ?: 'GET';
        $uri = new Uri('');
        $body = new Stream('php://temp');

        return new ServerRequest($method, $uri, $server, $body, '1.1');
    }
}
