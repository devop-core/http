<?php
namespace DevOp\Core\Http;

use Psr\Http\Message\UriInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\RequestInterface;

class Request implements RequestInterface
{

    use MessageTrait;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $requestTarget;

    /**
     * @var UriInterface
     */
    private $uri;

    /**
     * 
     * @param string $method
     * @param UriInterface $uri
     * @param array $headers
     * @param StreamInterface|null $body
     * @param string $protocolVersion
     */
    public function __construct($method, UriInterface $uri, array $headers = [], $body = null, $protocolVersion = '1.1')
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

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return self
     */
    public function withMethod($method)
    {
        if ($method === $this->method) {
            return $this;
        }

        $clone = clone $this;
        $clone->method = $method;

        return $clone;
    }

    /**
     * @return string
     */
    public function getRequestTarget()
    {

        if ($this->requestTarget) {
            return $this->requestTarget;
        }

        $target = $this->uri->getPath();

        if ($target === '') {
            $target .= '/';
        }

        if ($this->uri->getQuery()) {
            $target .= '?' . $this->uri->getQuery();
        }

        return $target;
    }

    /**
     * @param string $requestTarget
     * @return self
     */
    public function withRequestTarget($requestTarget)
    {
        if ($requestTarget === $this->requestTarget) {
            return $this;
        }

        $clone = clone $this;
        $clone->requestTarget = $requestTarget;

        return $clone;
    }

    /**
     * @return UriInterface
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param UriInterface $uri
     * @param boolean $preserveHost
     * @return self
     */
    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        if ($uri === $this->uri) {
            return $this;
        }

        $clone = clone $this;
        $clone->uri = $uri;

        if ($preserveHost) {
            if (!$clone->hasHeader('host')) {
                $clone->headers['host'] = 'Host';
                $clone->headers['Host'] = [$uri->getHost()];
            }
        }

        return $clone;
    }
}
