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
        $this->message = new \DevOp\Core\Http\Message();
    }

    public function testGetBody()
    {
        $this->assertNull($this->message->getBody());
    }
    
    public function testGetProtocolVersion()
    {
        $this->assertEquals('1.1', $this->message->getProtocolVersion());
    }

    public function testWithProtocolVersion()
    {
        $clone = $this->message->withProtocolVersion('2.0');
        $this->assertEquals('2.0', $clone->getProtocolVersion());
    }
}
