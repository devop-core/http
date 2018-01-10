<?php
namespace DevOp\Core\Test;

class MessageTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \DevOp\Core\Http\Message
     */
    protected $message;

    public function setUp()
    {
        $this->message = new \DevOp\Core\Http\Request('GET', '');
    }

    public function testGetBody()
    {
        $this->assertEquals('', $this->message->getBody());
    }

    public function testWithBody()
    {
        $clone = $this->message->withBody(new \DevOp\Core\Http\Stream(''));
        $this->assertEquals('', $clone->getBody());
    }

    public function testGetProtocolVersion()
    {
        $this->assertEquals('1.1', $this->message->getProtocolVersion());
    }

    public function testWithProtocolVersion()
    {
        $clone = $this->message->withProtocolVersion('1.0');
        $this->assertEquals('1.0', $clone->getProtocolVersion());
    }
}
