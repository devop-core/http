<?php
namespace DevOp\Core\Http\Test\Factory;

use Psr\Http\Message\StreamInterface;
use DevOp\Core\Http\Factory\StreamFactory;

class StreamFactoryTest extends \PHPUnit_Framework_TestCase
{
    
    public function testCreateStream()
    {
        $stream = (new StreamFactory())->createStream('test');
        $this->isInstanceOf(StreamInterface::class, $stream);
    }
    
    public function testCreateStreamFromFile()
    {
        $stream = (new StreamFactory())->createStreamFromFile('php://temp', 'w+');
        $this->isInstanceOf(StreamInterface::class, $stream);
    }
    
    public function testCreateStreamFromResource()
    {
        $resource = fopen('php://temp', 'w+');
        $stream = (new StreamFactory())->createStreamFromResource($resource);
        $this->assertInstanceOf(StreamInterface::class, $stream);
        fclose($resource);
    }
}