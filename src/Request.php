<?php
namespace DevOp\Core\Http;

use DevOp\Core\Http\Uri;
use DevOp\Core\Http\Stream;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\RequestInterface;

class Request implements RequestInterface
{

    use MessageTrait;
    use RequestTrait;

    /**
     * 
     * @param string $method
     * @param Uri|string $uri
     * @param array $headers
     * @param Stream|string $body
     * @param null|string $version
     */
    public function __construct($method, $uri, array $headers = [], $body = 'php://memory', $version = '1.1')
    {

        $this->method = $method;
        $this->protocolVersion = $version;
        $this->headers = $headers;

        if (!$uri instanceof UriInterface) {
            $uri = new Uri($uri);
        }

        if (!$body instanceof StreamInterface) {
            $body = new Stream($body);
        }

        $this->uri = $uri;
        $this->body = $body;
    }
}
