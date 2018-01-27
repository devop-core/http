<?php
namespace DevOp\Core\Http;

use Psr\Http\Message\UriInterface;

trait RequestTrait
{

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var string
     */
    private $requestTarget;

    /**
     * @var UriInterface
     */
    private $uri;

    /**
     * @param string $name
     * @return boolean
     */
    abstract public function hasHeader($name);

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return \DevOp\Core\Http\Request|$this
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
     * @return \DevOp\Core\Http\Request|$this
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
     * @return \DevOp\Core\Http\Request|$this
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
