<?php
namespace DevOp\Core\Http\Factory;

use DevOp\Core\Http\Request;
use Interop\Http\Factory\RequestFactoryInterface;

class RequestFactory implements RequestFactoryInterface
{

    public function createRequest($method, $uri)
    {
        return new Request($method, $uri);
    }
}
