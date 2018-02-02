<?php
namespace DevOp\Core\Http\Factory;

use DevOp\Core\Http\Uri;
use Interop\Http\Factory\UriFactoryInterface;

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
