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
        $uri = (new \DevOp\Core\Http\Factory\UriFactory())->createUri('');
        $this->request = (new \DevOp\Core\Http\Factory\RequestFactory())->createRequest('GET', $uri);
    }

    public function testGetBody()
    {
        $this->assertNull($this->request->getBody());
    }

    public function testGetMethod()
    {
        $this->assertEquals('GET', $this->request->getMethod());
    }

    public function testWithMethod()
    {
        $clone = $this->request->withMethod('TRACE');
        $this->assertEquals('TRACE', $clone->getMethod());
    }

    public function testGetProtocolVersion()
    {
        $this->assertEquals('1.1', $this->request->getProtocolVersion());
    }

    public function testWithProtocolVersion()
    {
        $clone = $this->request->withProtocolVersion('2.0');
        $this->assertEquals('2.0', $clone->getProtocolVersion());
    }
}
