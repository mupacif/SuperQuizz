<?php 
use Quizz\DAO\UserDAO;
require_once __DIR__.'/vendor/autoload.php';


$app= new Silex\Application();
$app['debug'] = true;




$app->register(new Silex\Provider\DoctrineServiceProvider());

require __DIR__.'/app/dev.php';

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));

$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));

$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'quizz' => array(
            'pattern' => '^/quizz/',
            'anonymous' => false,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/quizz/login_check'),
            'users' => function () use ($app) {
                return new Quizz\DAO\UserDAO($app['db']);
            },
            'logout' => array('logout_path' => '/quizz/logout', 'invalidate_session' => true),
        ),
    ),
));
$app['security.access_rules'] = array(
    array('^/quizz/admin', 'ROLE_ADMIN'),
    array('^/quiss/.*$', 'ROLE_USER'),
);


$app['dao.quizz'] = function($app){
    return new Quizz\DAO\QuizzDAO($app['db']);
};


require __DIR__.'/app/route.php';

$app->run();