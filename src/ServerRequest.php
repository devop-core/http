<?php
namespace DevOp\Core\Http;

use DevOp\Core\Http\Request;
use Psr\Http\Message\ServerRequestInterface;

class ServerRequest extends Request implements ServerRequestInterface
{

    use MessageTrait;
    use RequestTrait;

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var array
     */
    private $cookieParams = [];

    /**
     * @var string
     */
    private $parsedBody;

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
     * 
     * @return ServerRequest
     */
    public static function createFromGlobals()
    {

        $uri = Uri::createFromGlobals();

        $method = 'GET';
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $method = $_SERVER['REQUEST_METHOD'];
        }

        $headers = [];
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
        }

        $body = new Stream('php://input');

        $protocol = '1.1';
        if (isset($_SERVER['SERVER_PROTOCOL'])) {
            $protocol = str_replace('HTTP/', '');
        }

        $serverRequest = new ServerRequest($method, $uri, $headers, $body, $protocol);

        return $serverRequest
                ->withQueryParams($_GET)
                ->withParsedBody($_POST)
                ->withCookieParams($_COOKIE)
                ->withUploadedFiles(UploadedFile::createFromGlobal());
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
     * @return string
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
     * @param string $data
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
     * @return \DevOp\Core\Http\ServerRequest|$this
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
