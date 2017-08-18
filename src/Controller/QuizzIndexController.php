<?php
/**
 * Created by PhpStorm.
 * User: mupac_000
 * Date: 17-08-17
 * Time: 15:59
 */

namespace Quizz\Controller;


use Silex\Application;

class QuizzIndexController
{
    public function indexAction(Application $app)
    {

        $categories = $app['dao.quizz']->getAllCategories();
        return $app['twig']->render('index.html', array('categories' => $categories));
    }

    public function LoadPageAction(Application $app)
    {
        return $app['twig']->render('loadPage.html');
    }
}