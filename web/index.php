<?php 

require_once __DIR__.'/../vendor/autoload.php';

$app= new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider());

require __DIR__.'/../app/dev.php';

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));


$app['dao.quizz'] = function($app){
    return new Quizz\DAO\QuizzDAO($app['db']);
};


require __DIR__.'/route.php';

$app->run();