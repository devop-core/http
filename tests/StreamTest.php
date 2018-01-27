<?php
namespace DevOp\Core\Http\Test;

use DevOp\Core\Http\Stream;

class StreamTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Psr\Http\Message\StreamInterface
     */
    private $stream;
    
    public function setUp()
    {
        $this->stream = new Stream('php://memory', 'wb+');
    }

    public function testStreamIsReadable()
    {
        $this->assertTrue($this->stream->isReadable());
    }

    public function testStreamIsWritable()
    {
        $this->assertTrue($this->stream->isWritable());
    }

    public function testStreamIsSeekable()
    {
        $this->assertTrue($this->stream->isSeekable());
    }
}
