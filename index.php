<?php
include_once './vendor/autoload.php';

$serverRequest = DevOp\Core\Http\ServerRequest::createFromGlobals();
var_dump($serverRequest);
