<?php
/**
 * Created by PhpStorm.
 * User: mupac_000
 * Date: 17-08-17
 * Time: 16:49
 */

namespace Quizz\Controller;
use Quizz\Domain\Question;
use Symfony\Component\HttpFoundation\Response;



use Silex\Application;

class QuizzTesterController
{
    public function indexAction($category,$numTest,Application $app)
    {
        $questions = $app['dao.quizz']->getQuestionsOf($category,$numTest);

        return $app['twig']->render('test.html.twig', array('questions' => $questions));

    }

}