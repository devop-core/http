<?php
namespace DevOp\Core\Http;

use Psr\Http\Message\RequestInterface;

class Request implements RequestInterface
{

    use MessageTrait;
    use RequestTrait;
    
    public function __construct($method, $uri, array $headers = [], $body = null, $version = '1.1')
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
        $this->protocolVersion = $version;
    }
}
