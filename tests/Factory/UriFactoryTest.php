<?php
namespace DevOp\Core\Http\Test\Factory;

use DevOp\Core\Http\Factory\UriFactory;

class UriFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateUri()
    {
        $uri = (new UriFactory())->createUri('http://example.com');
        $this->assertInstanceOf(\Psr\Http\Message\UriInterface::class, $uri);
    }
}
