<?php
/**
 * Created by PhpStorm.
 * User: mupac_000
 * Date: 17-08-17
 * Time: 15:00
 */

namespace Quizz\Controller;


use Silex\Application;

/***
 * Class ApiRestController provide a rest interface
 * @package Quizz\Controller
 */
class ApiRestController
{

    public function getAllCategoriesName(Application $app)
    {
        $categories = $app['dao.quizz']->getAllCategoriesName();
        return $app->json($categories);

    }
}