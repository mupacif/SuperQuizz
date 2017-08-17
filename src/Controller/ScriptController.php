<?php
/**
 * Created by PhpStorm.
 * User: mupac_000
 * Date: 17-08-17
 * Time: 15:55
 */

namespace Quizz\Controller;


use Quizz\DAO\QuizzDAO;
use Silex\Application;

class ScriptController
{
    public function saveInDb($nameOfFile,$app)
    {
        $category = substr($nameOfFile,0,2);
        $numOfTest= substr($nameOfFile,2,3);
        $numOfQuestion = substr($nameOfFile,5,2);
        $answers = substr($nameOfFile,7,1);
        $correctAsnwer = substr($nameOfFile,8,1);

        $app['db']->insert(QuizzDAO::$dbName, array(QuizzDAO::$nameCategory=>$category,QuizzDAO::$nameNumTest=>$numOfTest,QuizzDAO::$nameNumQuestion=>$numOfQuestion,QuizzDAO::$nameQuantityAns=> $answers,QuizzDAO::$nameNumCorrectAns=>$correctAsnwer));



    }
    public function stringToDBformat($nameOfFile)
    {
        $category = substr($nameOfFile, 0, 2);
        $numOfTest = substr($nameOfFile, 2, 3);
        $numOfQuestion = substr($nameOfFile, 5, 2);
        $answers = substr($nameOfFile, 7, 1);
        $correctAsnwer = substr($nameOfFile, 8, 1);

        return "category:" . $category . " / numOfTest : " . $numOfTest . " / numOfQuestion : " . $numOfQuestion . " / answers: " . $answers . " / correctAsnwer : " . $correctAsnwer;

    }

    public function putFilesIntoDb(Application $app)
    {
        $path= './images';
        $dir = dir($path);

        $response = "";

        //array of files
        $filesNames = [];
        while($name = $dir->read())
        {
            $filesNames[] = $name;
        }

        foreach($filesNames as $name)
        {
            //we take all file with a name bigger than 3 characters
            if(strlen($name)>3)
            {
                //rest
                $response = $response.''.$this->stringToDBformat($name).'<br/>';
                // save in db

                $this->saveInDb($name,$app);
            }
        }

        return new Response($response);
    }
}