<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

/**
 * @var Composer\Autoload\ClassLoader
 */
$loader = require __DIR__ . '/../app/autoload.php';
include_once __DIR__ . '/../app/bootstrap.php.cache';

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();

if (getenv('APP_ENV') !== 'dev') {
    if (!isset($_SERVER['HTTP_SURROGATE_CAPABILITY']) ||
        false === strpos($_SERVER['HTTP_SURROGATE_CAPABILITY'], 'ESI/1.0')
    ) {
        $kernel = new AppCache($kernel);
    }
}

Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
