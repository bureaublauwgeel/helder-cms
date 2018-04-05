<?php

use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/../vendor/autoload.php';

$kernel = new AppKernel('prod', false);

if (getenv('APP_ENV') !== 'dev') {
    if (!isset($_SERVER['HTTP_SURROGATE_CAPABILITY']) ||
        false === strpos($_SERVER['HTTP_SURROGATE_CAPABILITY'], 'ESI/1.0')) {
        $kernel = new AppCache($kernel);
    }
}

$kernel = new AppCache($kernel);

Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
/** @noinspection PhpUnhandledExceptionInspection */
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
