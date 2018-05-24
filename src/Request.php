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
    public function __construct($method, UriInterface $uri, array $headers = [], $body, $protocolVersion = '1.1')
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->body = $body;
        
        foreach ($headers AS $header => $value) {
            $this->headersName[strtolower($header)] = $header;
            $this->headers[$header] = !is_array($value) ? [$value] : $value;
        }
        
        if (!$this->hasHeader('Host')) {
            if (!$uri = $this->uri->getHost()) {
                $uri = 'localhost';
            }
            $this->headersName['host'] = 'Host';
            $this->headers['Host'] = [$uri];
        }

        $this->protocolVersion = $protocolVersion;
    }
}
