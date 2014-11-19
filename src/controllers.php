<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;
use Silex\Provider\TwigServiceProvider;


$app->match('/', function (Request $request) use ($app) {
    
    return $app['twig']->render('index.html.twig', array());

})->bind('homepage');

$app->error(function (\Exception $e, $code) use ($app) {

        if ($app['debug']) {

            return;
        }
        $page = 404 == $code ? '404.html.twig' : '500.html.twig';

        return new ResponseResponse($app['twig']->render($page, array('code' => $code)), $code);
    });





