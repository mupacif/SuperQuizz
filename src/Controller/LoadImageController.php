<?php
namespace Quizz\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Quizz\DAO\QuizzDAO;

class LoadImageController
{

    public function loadAction(Request $request, Application $app)
    {
        $file = $request->files->get('file');
        if ($file !== null) {

            //the name
            $nameOfFile = $file->getClientOriginalName();

            /***
             *  to get infos from the name
             */
            //ex : A1 001 01 23
            $category = substr($nameOfFile,0,2);
            $numOfTest= substr($nameOfFile,2,3);
            $numOfQuestion = substr($nameOfFile,5,2);
            $correctAnswer = substr($nameOfFile,7,1);
            $answers = substr($nameOfFile,8,1);


            $response = "category:".$category." / numOfTest : ".$numOfTest." / numOfQuestion : ".$numOfQuestion." / answers: ".$answers." / correctAsnwer : ".$correctAnswer;

            // insertion inside your database



            $path = 'images/';
            $file->move($path, $file->getClientOriginalName());

          /*  $app['db']->insert('maindb', array('Category'=>$category,'Num_Test'=>$numOfTest,'Num_Question'=>$numOfQuestion,'Num_Correct_Ans'=>$correctAnswer,'Quantity_Ans'=> $answers));
*/
            $app['db']->insert(QuizzDAO::$dbName, array(QuizzDAO::$nameCategory=>strval($category),QuizzDAO::$nameNumTest=>$numOfTest,QuizzDAO::$nameNumQuestion=>$numOfQuestion,QuizzDAO::$nameQuantityAns=> $answers,QuizzDAO::$nameNumCorrectAns=>$correctAnswer));


            return new Response($response);
        } else {
            return new Response("An error ocurred. Did you really send a file?");
        }

    }

}


