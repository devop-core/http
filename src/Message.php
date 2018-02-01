<?php
namespace DevOp\Core\Http;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\MessageInterface;

class Message implements MessageInterface
{

    use MessageTrait;
    
    /**
     * @param StreamInterface|resource|string $stream
     * @param string $mode
     * @return \DevOp\Core\Http\Stream|StreamInterface
     * @throws \InvalidArgumentException
     */
    public function getStream($stream, $mode = 'r')
    {
        if ($stream instanceof StreamInterface) {
            return $stream;
        }
        
        if (!is_string($stream) && !is_resource($stream)) {
            throw new \InvalidArgumentException('Stream must be a string or resource.');
        }
        
        return new Stream($stream, $mode);
    }
    
    /**
     * @param array $headers
     */
    public function setHeaders(array $headers = [])
    {
        foreach ($headers AS $header => $value) {
            $this->headersName[strtolower($header)] = $header;
            $this->headers[$header] = $value;
        }
    }
}
