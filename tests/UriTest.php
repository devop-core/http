<?php
namespace DevOp\Core\Http\Test;

class UriTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \DevOp\Core\Http\Uri
     */
    private $uri;

    public function setUp()
    {
        $this->uri = new \DevOp\Core\Http\Uri('https://devop:pass@localhost:1337/?a=b&c=d#fragment');
    }

    public function testGetURI()
    {
        $this->assertEquals('https', $this->uri->getScheme());
        $this->assertEquals('devop:pass', $this->uri->getUserInfo());
        $this->assertEquals('localhost', $this->uri->getHost());
        $this->assertEquals(1337, $this->uri->getPort());
        $this->assertEquals('/', $this->uri->getPath());
        $this->assertEquals('a=b&c=d', $this->uri->getQuery());
        $this->assertEquals('fragment', $this->uri->getFragment());
    }
    
    public function testWithScheme()
    {
        $uri = $this->uri->withScheme('http');
        $this->assertEquals('http', $uri->getScheme());
    }
    
    public function testWithUserInfo()
    {
        $uri = $this->uri->withUserInfo('new:pass');
        $this->assertEquals('new:pass', $uri->getUserInfo());
    }
    
    public function testWithHost()
    {
        $uri = $this->uri->withHost('example.net');
        $this->assertEquals('example.net', $uri->getHost());
    }
    
    public function testWithPort()
    {
        $uri = $this->uri->withPort(443);
        $this->assertEquals(443, $uri->getPort());
    }
    
    public function testWithPath()
    {
        $uri = $this->uri->withPath('/another-path/');
        $this->assertEquals('/another-path/', $uri->getPath());
    }
    
    public function testWithQuery()
    {
        $uri = $this->uri->withQuery('1=2');
        $this->assertEquals('1=2', $uri->getQuery());
    }
}
