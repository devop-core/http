<?php
namespace DevOp\Core\Http\Test;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \DevOp\Core\Http\Request
     */
    protected $request;

    public function setUp()
    {
        $this->request = new \DevOp\Core\Http\Request('GET', '');
    }

    public function testGetProtocolVersion()
    {
        $this->assertEquals('GET', $this->request->getMethod());
    }

    public function testWithProtocolVersion()
    {
        $clone = $this->request->withMethod('TRACE');
        $this->assertEquals('TRACE', $clone->getMethod());
    }
}
