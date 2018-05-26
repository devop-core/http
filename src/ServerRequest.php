<?php
namespace DevOp\Core\Http;

use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequest extends Request implements ServerRequestInterface
{

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var array
     */
    private $cookieParams = [];

    /**
     * @var array
     */
    private $parsedBody = [];

    /**
     * @var array
     */
    private $queryParams = [];

    /**
     * @var array
     */
    private $serverParams = [];

    /**
     * @var array
     */
    private $uploadedFiles = [];

    /**
     * @param string $method
     * @param UriInterface $uri
     * @param array $headers
     * @param \Psr\Http\Message\StreamInterface|null $body
     * @param string $version
     * @param array $serverParams
     */
    public function __construct($method, UriInterface $uri, array $headers = [], $body = null, $version = '1.1', array $serverParams = [])
    {
        $this->serverParams = $serverParams;
        parent::__construct($method, $uri, $headers, $body, $version);
    }

    public static function getUriFromGlobals(array $server = [])
    {
        $uri = new Uri('');
        $uri = $uri->withScheme(!empty($server['HTTPS']) && $server['HTTPS'] !== 'off' ? 'https' : 'http');
        $hasPort = false;
        if (isset($server['HTTP_HOST'])) {
            $hostHeaderParts = explode(':', $server['HTTP_HOST']);
            $uri = $uri->withHost($hostHeaderParts[0]);
            if (isset($hostHeaderParts[1])) {
                $hasPort = true;
                $uri = $uri->withPort((int) $hostHeaderParts[1]);
            }
        } elseif (isset($server['SERVER_NAME'])) {
            $uri = $uri->withHost($server['SERVER_NAME']);
        } elseif (isset($server['SERVER_ADDR'])) {
            $uri = $uri->withHost($server['SERVER_ADDR']);
        }
        if (!$hasPort && isset($server['SERVER_PORT'])) {
            $uri = $uri->withPort($server['SERVER_PORT']);
        }
        $hasQuery = false;
        if (isset($server['REQUEST_URI'])) {
            $requestUriParts = explode('?', $server['REQUEST_URI'], 2);
            $uri = $uri->withPath($requestUriParts[0]);
            if (isset($requestUriParts[1])) {
                $hasQuery = true;
                $uri = $uri->withQuery($requestUriParts[1]);
            }
        }
        if (!$hasQuery && isset($server['QUERY_STRING'])) {
            $uri = $uri->withQuery($server['QUERY_STRING']);
        }
        return $uri;
    }

    /**
     * @return string
     */
    public function getAttribute($name, $default = null)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }
        return $default;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function getCookieParams()
    {
        return $this->cookieParams;
    }

    /**
     * @return mixed
     */
    public function getParsedBody()
    {
        return $this->parsedBody;
    }

    /**
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * @return array
     */
    public function getServerParams()
    {
        return $this->serverParams;
    }

    /**
     * @return array
     */
    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }

    /**
     * @param string $name
     * @param string $value
     * @return \DevOp\Core\Http\ServerRequest
     */
    public function withAttribute($name, $value)
    {
        $clone = clone $this;
        $clone->attributes[$name] = $value;

        return $clone;
    }

    /**
     * @param array $cookies
     * @return \DevOp\Core\Http\ServerRequest
     */
    public function withCookieParams(array $cookies)
    {
        $clone = clone $this;
        $clone->cookieParams = $cookies;

        return $clone;
    }

    /**
     * @param array $data
     * @return \DevOp\Core\Http\ServerRequest
     */
    public function withParsedBody($data)
    {
        $clone = clone $this;
        $clone->parsedBody = $data;

        return $clone;
    }

    /**
     * @param array $query
     * @return \DevOp\Core\Http\ServerRequest
     */
    public function withQueryParams(array $query)
    {
        $clone = clone $this;
        $clone->queryParams = $query;

        return $clone;
    }

    /**
     * @param array $uploadedFiles
     * @return \DevOp\Core\Http\ServerRequest
     */
    public function withUploadedFiles(array $uploadedFiles)
    {
        $clone = clone $this;
        $clone->uploadedFiles = $uploadedFiles;

        return $clone;
    }

    /**
     * @param string $name
     * @return self
     */
    public function withoutAttribute($name)
    {
        if (!array_key_exists($name, $this->attributes)) {
            return $this;
        }

        $clone = clone $this;
        unset($clone->attributes[$name]);

        return $clone;
    }
}
