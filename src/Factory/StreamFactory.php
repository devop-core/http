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
        $resource = fopen("php://temp", "r+");
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

        return $this->createStreamFromResource($resource);
    }

    /**
     * @param resource $resource
     * @return StreamInterface
     */
    public function createStreamFromResource($resource)
    {
        var_dump($resource);
        return new Stream($resource);
    }
}
