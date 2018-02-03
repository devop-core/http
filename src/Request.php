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
            $this->body = (new Factory\StreamFactory())->createStreamFromFile($body, "wb+");
        }

        foreach ($headers AS $header => $value) {
            $normalize = strtolower($value);
            $this->headersName[$header] = $normalize;
            $this->headers[$normalize] = $value;
        }
        
        if (!$this->hasHeader('host')) {
            $this->headersName['host'] = 'Host';
            $this->headers['Host'] = [!empty($this->uri->getHost()) ? $this->uri->getHost() : 'localhost'];
        }

        $this->protocolVersion = $protocolVersion;
    }
}
