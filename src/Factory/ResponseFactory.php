<?php
namespace DevOp\Core\Http\Factory;

use DevOp\Core\Http\Response;
use DevOp\Core\Http\Factory\StreamFactory;
use Interop\Http\Factory\ResponseFactoryInterface;

class ResponseFactory implements ResponseFactoryInterface
{
    
    /**
     * @param int $code
     * @return Response
     */
    public function createResponse($code = 200)
    {
        $body = (new StreamFactory())->createStreamFromFile('php://temp', "wb+");
        
        return new Response($body, $code);
    }
}
