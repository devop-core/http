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
     * @param string|UriInterface $uri
     * @param array $headers
     * @param string|resource|StreamInterface $body
     * @param string $protocolVersion
     */
    public function __construct($method, UriInterface $uri, array $headers = [], $body = 'php://temp', $protocolVersion = '1.1')
    {
        $this->method = $method;
        $this->uri = new Uri($uri);

        if ($body instanceof StreamInterface) {
            $this->body = $body;
        } else if (is_resource($body)) {
            $this->body = (new Factory\StreamFactory())->createStreamFromResource($body);
        } else {
            $this->body = (new Factory\StreamFactory())->createStreamFromFile($body, "r+");
        }

        $this->headers = $headers;
        $this->protocolVersion = $protocolVersion;
    }
}
