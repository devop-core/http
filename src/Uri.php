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

    public function __construct($uri = '')
    {
        
        if ($uri instanceof UriInterface) {
            return $uri;
        }
        
        if (!is_string($uri)) {
            throw new \InvalidArgumentException('Argument must be a string.');
        }
        
        $components = parse_url($uri);
        if (isset($components['scheme'])) {
            $this->scheme = $components['scheme'];
        }
        if (isset($components['host'])) {
            $this->host = $components['host'];
        }
        if (isset($components['port']) && !in_array($components['port'], [self::$schemes['http'], self::$schemes['https']])) {
            $this->port = $components['port'];
        }
        if (isset($components['path'])) {
            $this->path = $components['path'];
        }
        if (isset($components['query'])) {
            $this->query = $components['query'];
        }
        if (isset($components['fragment'])) {
            $this->fragment = $components['fragment'];
        }
        if (isset($components['user'])) {
            $this->userInfo = $components['user'];
        }
        if (isset($components['pass'])) {
            $this->userInfo .= ':' . $components['pass'];
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $uri = $this->scheme;

        if ($this->userInfo !== null) {
            $uri .= "//{$this->userInfo}";
        }

        if ($this->port !== null && !in_array($this->port, [self::$schemes['http'], self::$schemes['https']])) {
            $uri .= ":{$this->port}";
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
     * @return \DevOp\Core\Http\Uri|$this
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
     * @return \DevOp\Core\Http\Uri|$this
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
     * @return \DevOp\Core\Http\Uri|$this
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
     * @return \DevOp\Core\Http\Uri|$this
     */
    public function withPort($port)
    {
        if ($port === $this->port) {
            return $this;
        }

        $clone = clone $this;
        $clone->port = $port;

        return $clone;
    }

    /**
     * @param string  $query
     * @return \DevOp\Core\Http\Uri|$this
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
     * @return \DevOp\Core\Http\Uri|$this
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
     * @return \DevOp\Core\Http\Uri|$this
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
