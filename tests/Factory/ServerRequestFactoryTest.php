<?php
namespace DevOp\Core\Http\Test\Factory;

use DevOp\Core\Http\Factory\UriFactory;
use DevOp\Core\Http\Factory\ServerRequestFactory;

class ServerRequestFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateServerRequestFactory()
    {
        $uri = (new UriFactory())->createUri('http://example.com');
        $serverRequest = (new ServerRequestFactory())->createServerRequest('GET', $uri);
        $this->isInstanceOf(\Psr\Http\Message\ServerRequestInterface::class, $serverRequest);
    }

    public function testCreateServerRequestFromArray()
    {
        $server = ['REQUEST_METHOD' => 'POST'];
        $serverRequest = (new ServerRequestFactory())->createServerRequestFromArray($server);
        $this->assertInstanceOf(\Psr\Http\Message\ServerRequestInterface::class, $serverRequest);
    }
}
