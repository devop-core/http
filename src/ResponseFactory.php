<?php
namespace DevOp\Core\Http;

use DevOp\Core\Http\Response;
use DevOp\Core\Http\StreamFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class ResponseFactory implements ResponseFactoryInterface
{

    /**
     * @param int $code
     * @return Response
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface
    {
        $body = (new StreamFactory())->createStreamFromFile('php://temp', "wb+");

        return new Response($body, $code);
    }
}
