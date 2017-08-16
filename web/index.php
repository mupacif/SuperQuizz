<?php 

require_once __DIR__.'/../vendor/autoload.php';

$app= new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider());
$app['db.options'] = array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => '',
            'user'      => 'mupacif',
            'password'  => '',
            'charset'   => 'utf8mb4',
    );

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

require __DIR__.'/route.php';

$app->run();