<?php 

require_once __DIR__.'/../vendor/autoload.php';

$app= new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\DoctrineServiceProvider());
$app['db.options'] = array(
            'driver'    => 'pdo_mysql',
            'host'      => 'localhost',
            'dbname'    => 'quizz',
            'user'      => 'root',
            'password'  => 'password',
            'charset'   => 'utf8mb4',
    );

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));


$app['dao.quizz'] = function($app){
    return new Quizz\DAO\QuizzDAO($app['db']);
};


require __DIR__.'/route.php';

$app->run();