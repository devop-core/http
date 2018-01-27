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
        $this->serverRequest = new \DevOp\Core\Http\ServerRequest('GET', '/');
    }

    public function testGetMethod()
    {
        $this->assertEmpty($this->serverRequest->getAttributes());
    }
}
