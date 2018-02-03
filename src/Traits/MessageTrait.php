<?php
namespace DevOp\Core\Http\Traits;

use Psr\Http\Message\StreamInterface;

trait MessageTrait
{

    /**
     * @var StreamInterface
     */
    private $body;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $headersName = [];

    /**
     * @var string
     */
    private $protocolVersion = 1.1;

    /**
     * @var StreamInterface
     */
    private $stream;

    /**
     * @return StreamInterface
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param StreamInterface $body
     * @return self
     */
    public function withBody(StreamInterface $body)
    {
        if ($body === $this->stream) {
            return $this;
        }

        $clone = clone $this;
        $clone->stream = $body;

        return $clone;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasHeader($name)
    {
        return isset($this->headersName[strtolower($name)]);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getHeader($name)
    {
        if ($this->hasHeader($name)) {
            return [$this->headers[$this->headersName[strtolower($name)]]];
        }
        return [];
    }

    public function getHeaderLine($name)
    {
        return implode(', ', $this->getHeader($name));
    }

    /**
     * @return array)
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return self
     */
    public function withHeader($name, $value)
    {
        $clone = new $this;

        $normalize = strtolower($name);

        if ($clone->hasHeader($name)) {
            unset($clone->headers[$this->headersName[$normalize]]);
            unset($clone->headersName[$normalize]);
        }

        $clone->headersName[$normalize] = $name;
        $clone->headers[$normalize] = !is_array($value) ? [$value] : $value;

        return $clone;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return self
     */
    public function withAddedHeader($name, $value)
    {
        $clone = new $this;

        $normalize = strtolower($name);

        if ($clone->hasHeader($name)) {
            $clone->headers[$normalize] = array_merge($this->headers, (!is_array($value) ? [$value] : $value));
        } else {
            $clone->headersName[$normalize] = $name;
            $clone->headers[$normalize] = !is_array($value) ? [$value] : $value;
        }

        return $clone;
    }

    /**
     * @param string $name
     * @return self
     */
    public function withoutHeader($name)
    {
        $clone = new $this;

        $normalize = strtolower($name);

        if ($clone->hasHeader($name)) {
            unset($clone->headers[$this->headersName[$normalize]]);
            unset($clone->headersName[$normalize]);
        }

        return $clone;
    }

    /**
     * @return string
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * @param string $version
     * @return self
     */
    public function withProtocolVersion($version)
    {
        if ($version === $this->protocolVersion) {
            return $this;
        }

        $clone = clone $this;
        $clone->protocolVersion = $version;

        return $clone;
    }
}
