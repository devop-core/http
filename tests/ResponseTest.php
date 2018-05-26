<?php
namespace DevOp\Core\Test\Http;

class ResponseTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \DevOp\Core\Http\Response
     */
    private $response;

    public function setUp()
    {
        $this->response = (new \DevOp\Core\Http\ResponseFactory())->createResponse(200);
    }

    public function testGetStatusCode()
    {
        $this->assertEquals(200, $this->response->getStatusCode());
    }

    public function testWithStatusCode()
    {
        $response = $this->response->withStatus(404);
        $this->assertEquals(404, $response->getStatusCode());
    }
}
