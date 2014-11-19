<?php

require_once __DIR__.'/../vendor/autoload.php';

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\ClassLoader\DebugClassLoader;
use Symfony\Component\HttpKernel\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;

$app = new Application();

$app->register(new UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
        'translator.messages' => array(),
    ));
$app->register(new Silex\Provider\SessionServiceProvider());
//TWIG
$app->register(new TwigServiceProvider(), array(
        'twig.path' => array(__DIR__.'/../templates/default'),
        'twig.options' => array('cache' => __DIR__.'/../cache'),
    ));


$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
            return $twig;
        }));

//FORMS
$app->register(new FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());

$yaml = new Parser();
$config = $yaml->parse(file_get_contents(__DIR__.'/../config/config.yml'));
$app['config'] = $config;

if($config['env'] == "dev"){
    ini_set('display_errors', 1);
    error_reporting(-1);
    DebugClassLoader::enable();
    ErrorHandler::register();
    if ('cli' !== php_sapi_name()) {
        ExceptionHandler::register();
    }
    require __DIR__.'/../config/dev.php';
}else{
    ini_set('display_errors', 0);
    require __DIR__.'/../config/prod.php';
}

$app['debug'] = true;


return $app;