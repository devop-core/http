<?php
namespace DevOp\Core\Http;

use Psr\Http\Message\UriInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\RequestInterface;

class Request implements RequestInterface
{

    use Traits\MessageTrait;
    use Traits\RequestTrait;

    /**
     * 
     * @param string $method
     * @param UriInterface $uri
     * @param array $headers
     * @param StreamInterface $body
     * @param string $protocolVersion
     */
    public function __construct($method, UriInterface $uri, array $headers = [], StreamInterface $body = null, $protocolVersion = '1.1')
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->stream = $body;
        $this->headers = $headers;
        $this->protocolVersion = $protocolVersion;
    }
}
