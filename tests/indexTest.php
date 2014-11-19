<?php

namespace MyApp\Tests;

use Silex\WebTestCase;

class IndexTest extends WebTestCase {

    /**
     * needed method to create app
     *
     * @return array|mixed|\Symfony\Component\HttpKernel\HttpKernel
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../src/app.php';
        $app['debug'] = true;
        $app['session.test'] = true;
        require __DIR__.'/../src/controllers.php';

        return $app;
    }

    public function testIndex()
    {
        $client = $this->createClient();
        $crawler = $client->request('GET', '/');

        //$this->assertTrue(true);
    }
} 