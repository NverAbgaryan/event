<?php

use Symfony\Component\HttpFoundation\Request;

//use Symfony\Component\Debug\Debug;

// If you don't want to setup permissions the proper way, just uncomment the following PHP line
// read http://symfony.com/doc/current/setup.html#checking-symfony-application-configuration-and-setup
// for more information
//umask(0000);
date_default_timezone_set('Asia/Tbilisi');
/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__ . '/../app/autoload.php';
//Debug::enable();
ini_set('max_execution_time', 900);
$kernel = new AppKernel('dev', true);
//$kernel->loadClassCache();


//$kernel->loadClassCache();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
