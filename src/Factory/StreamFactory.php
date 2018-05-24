<?php
namespace DevOp\Core\Http\Factory;

use DevOp\Core\Http\Stream;
use Psr\Http\Message\StreamInterface;
use Interop\Http\Factory\StreamFactoryInterface;

class StreamFactory implements StreamFactoryInterface
{

    /**
     * @param string $content
     * @return StreamInterface
     */
    public function createStream($content = '')
    {
        $resource = fopen("php://temp", "w+b");
        
        if (!is_resource($resource)) {
            throw new \InvalidArgumentException('Error while creating PHP stream');
        }
        
        fwrite($resource, $content);
        rewind($resource);

        return $this->createStreamFromResource($resource);
    }

    /**
     * @param string $filename
     * @param string $mode
     * @return StreamInterface
     */
    public function createStreamFromFile($filename, $mode = 'r')
    {
        $resource = fopen($filename, $mode);

        if (!is_resource($resource)) {
            throw new \InvalidArgumentException('Error while creating PHP stream');
        }
        
        return $this->createStreamFromResource($resource);
    }

    /**
     * @param resource $resource
     * @return StreamInterface
     */
    public function createStreamFromResource($resource)
    {
        return new Stream($resource);
    }
}
