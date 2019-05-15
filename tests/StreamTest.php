<?php
namespace DevOp\Core\Http\Test;

use PHPUnit\Framework\TestCase;

class StreamTest extends TestCase
{

    /**
     * @var \Psr\Http\Message\StreamInterface
     */
    private $stream;

    public function setUp()
    {
        $this->stream = (new \DevOp\Core\Http\StreamFactory())->createStream('test');
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
