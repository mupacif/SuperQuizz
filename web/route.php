<?php 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Quizz\Domain\Category;
use Doctrine\DBAL\Schema\Table;
use Silex\Route\SecurityTrait;


/***
 *  first page of the quizz
 */

$app->get('/quizz/index',"Quizz\Controller\QuizzIndexController::indexAction")->bind('quizz_home');


$app->get('/quizz/admin/uploadPage',"Quizz\Controller\QuizzIndexController::LoadPageAction")->bind('uploadPage');


/***
 * quizz page
 */

$app->get('/quizz/test/{category}/{numTest}',"Quizz\Controller\QuizzTesterController::indexAction")->bind('quizz_question');


/***
 * Load files from form
 */
$app->post('/load',"Quizz\Controller\LoadImageController::loadAction")->bind('loadImage');


 /***
  * REST API
  */

/***
 * get categories
 */
$app->get('/api/categories',"Quizz\Controller\ApiRestController::getAllCategoriesName")->bind('api_categories');


/***
 * Script to read files from folders
 * then put into db
 */
$app->get('/script/PutFilesIntoDb',"Quizz\Controller\ScriptController::putFilesIntoDb");

$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');;


$app->get('/script/setUpUsers',

    function() use ($app) {

        $schema = $app['db']->getSchemaManager();
        if (!$schema->tablesExist('users')) {
            $users = new Table('users');
            $users->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
            $users->setPrimaryKey(array('id'));
            $users->addColumn('username', 'string', array('length' => 32));
            $users->addUniqueIndex(array('username'));
            $users->addColumn('password', 'string', array('length' => 255));
            $users->addColumn('roles', 'string', array('length' => 255));

            $schema->createTable($users);


            $passwordUser = "student";
            $passwordTeacher = "teacher";



            $app['db']->insert('users', array(
                'username' => 'student',
                'password' => $app['security.default_encoder']->encodePassword($passwordUser, ''),
                'roles' => 'ROLE_USER'
            ));

            $app['db']->insert('users', array(
                'username' => 'admin',
                'password' => $app['security.default_encoder']->encodePassword($passwordTeacher,''),
                'roles' => 'ROLE_ADMIN'
            ));
            return new Response("success");
        }else
            return new Response("fail");

    });


