<?php
namespace DevOp\Core\Http;

use DevOp\Core\Http\Uri;
use DevOp\Core\Http\Stream;
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
     * @param string|null $version
     */
    public function __construct($method, $uri, array $headers = [], $body = 'php://memory', $version = '1.1')
    {

        $this->method = $method;
        $this->uri = new Uri($uri);
        $this->headers = $headers;
        $this->body = new Stream($body);
        $this->protocolVersion = $version;
    }
}
