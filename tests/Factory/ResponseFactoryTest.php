<?php
namespace DevOp\Core\Http\Test\Factory;

class ResponseFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateResponseFactory()
    {
        $response = (new \DevOp\Core\Http\Factory\ResponseFactory())->createResponse(200);
        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $response);
    }
}
