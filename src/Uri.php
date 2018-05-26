<?php
namespace DevOp\Core\Http;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{

    /**
     * @var array
     */
    private static $schemes = array(
        'http' => 80,
        'https' => 443
    );

    /**
     * @var string|null
     */
    private $scheme;

    /**
     * @var string|null
     */
    private $userInfo;

    /**
     * @var string|null
     */
    private $host;

    /**
     * @var int|null
     */
    private $port;

    /**
     * @var string
     */
    private $path = '';

    /**
     * @var string|null
     */
    private $query;

    /**
     * @var string|null
     */
    private $fragment;

    /**
     * @param UriInterface|string $uri
     * @return UriInterface
     */
    public function __construct($uri = '')
    {

        if ($uri instanceof UriInterface) {
            return $uri;
        }

        $parseUrl = parse_url($uri);
        if (empty($parseUrl)) {
            throw new \InvalidArgumentException;
        }

        $components = array_merge(array(
            'scheme' => '',
            'host' => '',
            'port' => null,
            'user' => null,
            'pass' => null,
            'path' => '',
            'query' => null,
            'fragment' => null
            ), $parseUrl);

        $this->scheme = $components['scheme'];
        $this->host = $components['host'];
        $this->port = $this->isStandartPort($components['port']);
        $this->path = $components['path'];
        $this->query = $components['query'];
        $this->fragment = $components['fragment'];
        $this->userInfo = implode(':', array_filter([$components['user'], $components['pass']]));
    }

    /**
     * @param int $port
     * @return int|null
     */
    public function isStandartPort($port)
    {
        if (!in_array($port, [self::$schemes['http'], self::$schemes['https']])) {
            return $port;
        }
        return null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $uri = $this->scheme;

        if ($this->userInfo !== null) {
            $uri .= "://{$this->userInfo}";
        }

        $uri .= $this->host;

        if ($this->port !== null && !in_array($this->port, [self::$schemes['http'], self::$schemes['https']])) {
            $uri .= ":{$this->host}{$this->port}";
        }

        $uri .= $this->path;

        if ($this->query !== null) {
            $uri .= "?{$this->query}";
        }

        if ($this->fragment !== null) {
            $uri .= "#{$this->fragment}";
        }

        return $uri;
    }

    /**
     * @return string
     */
    public function getAuthority()
    {
        return ($this->userInfo ?: $this->userInfo) . $this->host . ($this->port ?: ":{$this->port}");
    }

    /**
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return null|int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * @return string
     */
    public function getUserInfo()
    {
        return $this->userInfo;
    }

    /**
     * @param string $fragment
     * @return self
     */
    public function withFragment($fragment)
    {
        if ($fragment === $this->fragment) {
            return $this;
        }

        $clone = clone $this;
        $clone->fragment = $fragment;

        return $clone;
    }

    /**
     * @param string $host
     * @return self
     */
    public function withHost($host)
    {
        if ($host === $this->host) {
            return $this;
        }

        $clone = clone $this;
        $clone->host = $host;

        return $clone;
    }

    /**
     * @param string $path
     * @return self
     */
    public function withPath($path)
    {
        if ($path === $this->path) {
            return $this;
        }

        $clone = clone $this;
        $clone->path = $path;

        return $clone;
    }

    /**
     * @param int $port
     * @return self
     */
    public function withPort($port)
    {
        if ($port === $this->port) {
            return $this;
        }

        $clone = clone $this;
        $clone->port = (int) $port;

        return $clone;
    }

    /**
     * @param string  $query
     * @return self
     */
    public function withQuery($query)
    {
        if ($query === $this->query) {
            return $this;
        }

        $clone = clone $this;
        $clone->query = $query;

        return $clone;
    }

    /**
     * @param string $scheme
     * @return self
     */
    public function withScheme($scheme)
    {
        if ($scheme === $this->scheme) {
            return $this;
        }

        $clone = clone $this;
        $clone->scheme = $scheme;

        return $clone;
    }

    /**
     * @param string $user
     * @param string|null $password
     * @return self
     */
    public function withUserInfo($user, $password = null)
    {
        $userInfo = $user;
        if (null !== $password) {
            $userInfo .= ":{$password}";
        }

        if ($userInfo === $this->userInfo) {
            return $this;
        }

        $clone = clone $this;
        $clone->userInfo = $userInfo;

        return $clone;
    }
}
