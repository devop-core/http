<?php
include_once './vendor/autoload.php';

//$serverRequest = DevOp\Core\Http\ServerRequest::createFromGlobals();
//var_dump($serverRequest);
//$stream = (new \DevOp\Core\Http\Factory\StreamFactory())->createStream('test');
//var_dump($stream);

$uri = (new \DevOp\Core\Http\Factory\UriFactory())->createUri('');
$request = (new \DevOp\Core\Http\Factory\RequestFactory())->createRequest('GET', $uri);
var_dump($request);
