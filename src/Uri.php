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
    private $fragment;

    /**
     * @var string|null
     */
    private $host;

    /**
     * @var string|null
     */
    private $path;

    /**
     * @var string|null
     */
    private $port;

    /**
     * @var string|null
     */
    private $query;

    /**
     * @var string|null
     */
    private $scheme;

    /**
     * @var string|null
     */
    private $userInfo;

    /**
     * @return \DevOp\Core\Http\Uri
     */
    public static function createFromGlobals()
    {
        
        $uri = new Uri('');
        
        $scheme = 'http';
        if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
            $scheme .= 's';
        }
        
        $uri->withScheme($scheme);
        
        if (isset($_SERVER['REMOTE_PORT']) && (!isset(self::$schemes['http']) && !isset(self::$schemes['https']))) {
            $uri->withPort($_SERVER['REMOTE_PORT']);
        }
        
        if (isset($_SERVER['SERVER_NAME'])) {
            $host = $_SERVER['SERVER_NAME'];
        } else if ($_SERVER['SERVER_ADDR']) {
            $host = $_SERVER['SERVER_ADDR'];
        } else {
            $host = '127.0.0.1';
        }
        
        $uri->withHost($host);
        
        if (isset($_SERVER['QUERY_STRING'])) {
            $uri->withQuery(ltrim($_SERVER['QUERY_STRING'], '?'));
        }
        
        return $uri;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        $uri = $this->scheme;
        
        if ($this->userInfo) {
            $uri .= "//{$this->userInfo}";
        }
        
        if ($this->port && !array_key_exists($this->port, self::$defaultPorts)) {
            $uri .= ":{$this->port}";
        }
        
        $uri .= $this->path;
        
        if ($this->query) {
            $uri .= "?{$this->query}";
        }
        
        if ($this->fragment) {
            $uri .= "#{$this->fragment}";
        }
        
        return $uri;
    }

    public function getAuthority()
    {
        return ($this->userInfo ?: $this->userInfo) . $this->host . ($this->port ?: ":{$this->port}");
    }

    public function getFragment()
    {
        return $this->fragment;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getScheme()
    {
        return $this->scheme;
    }

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
