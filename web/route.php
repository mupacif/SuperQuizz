<?php 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Quizz\Domain\Category;



/***
 *  first page of the quizz
 */

$app->get('/quizz/index',"Quizz\Controller\QuizzIndexController::indexAction")->bind('quizz_home');

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


