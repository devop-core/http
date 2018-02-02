<?php
namespace DevOp\Core\Http;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;

class Response implements ResponseInterface
{

    use Traits\MessageTrait;

    /**
     * @link https://gist.github.com/Stoffo/53e093450aed067a8fa8
     * */
    private static $phrases = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Unordered Collection',
        426 => 'Upgrade Required',
        449 => 'Retry With',
        450 => 'Blocked by Windows Parental Controls',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        509 => 'Bandwidth Limit Exceeded',
        510 => 'Not Extended'
    );

    /**
     *
     * @var int
     */
    private $statusCode;

    /**
     *
     * @var string
     */
    private $reasonPhrase;

    /**
     * @param StreamInterface $body
     * @param int $code
     * @param array $headers
     */
    public function __construct(StreamInterface $body, $code = 200)
    {
        $this->statusCode = (int) $code;
        $this->body = $body;
    }

    /**
     *
     * @var int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param int $code
     * @param string $reasonPhrase
     * @return self
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        if ($code === $this->statusCode) {
            return $this;
        }

        $clone = clone $this;
        $clone->statusCode = $code;

        if (empty($reasonPhrase) && isset(self::$phrases[$code])) {
            $reasonPhrase = self::$phrases[$code];
        }

        $clone->reasonPhrase = $reasonPhrase;

        return $clone;
    }

    /**
     *
     * @var string
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }
}
