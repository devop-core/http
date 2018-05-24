<?php
namespace DevOp\Core\Http\Test\Factory;

use DevOp\Core\Http\Factory\RequestFactory;

class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    
    public function testCreateRequestFactory()
    {
        $request = (new RequestFactory())->createRequest('GET', 'http://example.com');
        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $request);
    }
}
