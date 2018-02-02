<?php
namespace DevOp\Core\Http\Test;

class ServerRequestTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \DevOp\Core\Http\ServerRequest
     */
    private $serverRequest;

    public function setUp()
    {
        $uri = (new \DevOp\Core\Http\Factory\UriFactory())->createUri('');
        $body = (new \DevOp\Core\Http\Factory\StreamFactory())->createStream('test');
        $this->serverRequest = new \DevOp\Core\Http\ServerRequest('GET', $uri, [], $body, '1.1');
    }

    public function testGetMethod()
    {
        $this->assertEmpty($this->serverRequest->getAttributes());
    }
}
