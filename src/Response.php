<?php
namespace DevOp\Core\Http;

use Psr\Http\Message\ResponseInterface;

class Response implements ResponseInterface
{
    use MessageTrait;
    
    /**
     *
     * @var string
     */
    private $reasonPhrase;
    
    /**
     *
     * @var int
     */
    private $statusCode;
    
    /**
     *
     * @var string
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
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
     * @return \DevOp\Core\Http\Response|$this
     */
    public function withStatus($code, $reasonPhrase = '')
    {
        if ($code === $this->statusCode) {
            return $this;
        }
        
        $clone = clone $this;
        $clone->statusCode = $code;
        $clone->reasonPhrase = $reasonPhrase;
        
        return $clone;
    }
}
