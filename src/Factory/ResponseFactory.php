<?php
namespace DevOp\Core\Http\Factory;

use DevOp\Core\Http\Stream;
use DevOp\Core\Http\Response;
use Interop\Http\Factory\ResponseFactoryInterface;

class ResponseFactory implements ResponseFactoryInterface
{
    
    public function createResponse($code = 200)
    {
        $body = (new StreamFactory())->createStreamFromFile('php://temp', "wb+");
        return new Response($body, $code);
    }
}
