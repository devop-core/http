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
        $uri = (new \DevOp\Core\Http\UriFactory())->createUri('');
        $this->request = (new \DevOp\Core\Http\RequestFactory())->createRequest('GET', $uri);
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

    public function testGetBody()
    {
        $this->isInstanceOf('\Psr\Http\Message\StreamInterface', $this->request->getBody());
    }
    
    public function testWithBody()
    {
        $stream = (new \DevOp\Core\Http\StreamFactory())->createStream('test');
        $clone = $this->request->withBody($stream);
        $this->assertSame('test', (string) $clone->getBody());
    }
    
    public function testGetHeaders()
    {
        $this->assertEquals(['Host' => ['localhost']], $this->request->getHeaders());
    }
    
    public function testWithHeader()
    {
        $clone = $this->request->withHeader('Host', 'dev.io');
        $this->assertEquals(['Host' => ['dev.io']], $clone->getHeaders());
    }
    
    public function testWithAddedHeader()
    {
        $clone = $this->request->withHeader('abc', ['xyz'])->withAddedHeader('abc', ['zyx']);
        $this->assertEquals('xyz, zyx', $clone->getHeaderLine('abc'));
    }
    
    public function testWithoutHeader()
    {
        $clone = $this->request->withoutHeader('Host');
        $this->assertEquals('', $clone->getHeaderLine('Host'));
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
