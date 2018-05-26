<?php

use DevOp\Core\Http\ServerRequestFactory;

include_once '../vendor/autoload.php';
//$request = (new ServerRequestFactory())->createServerRequest('GET', 'http://example.com/?query=abc');
//var_dump($request->getMethod());

//$streamFactory = (new \DevOp\Core\Http\StreamFactory())->createStream('test');
//var_dump((string) $streamFactory);

$uploadedFile = (new DevOp\Core\Http\UploadedFileFactory())->createUploadedFile($file, $size, $error, $clientFilename, $clientMediaType);
var_dump((string) $uploadedFile->getStream());