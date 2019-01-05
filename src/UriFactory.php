<?php
namespace DevOp\Core\Http;

use DevOp\Core\Http\Uri;
use Psr\Http\Message\UriFactoryInterface;

class UriFactory implements UriFactoryInterface
{

    /**
     * @param string $uri
     * @return Uri
     */
    public function createUri($uri = '')
    {
        return new Uri($uri);
    }
}
