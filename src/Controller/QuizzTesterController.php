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
use Symfony\Component\HttpFoundation\Request;


use Silex\Application;

class QuizzTesterController
{
    public function indexAction($category,$numTest,$numQuestion,Request $request,Application $app)
    {
     
     $finished=false;
   
   //if question is correct
       if(null !== $test = $app['dao.quizz']->getQuestionsOf($category,$numTest)
        )
       {
           

        
           $questions = $test-> getQuestions();
           //if number of question is small
           $numberOfQuestions = count($questions);
           if( $numberOfQuestions >= $numQuestion )
           {
               //if the num of question correlate with a question
               if( null !== $question = $questions[$numQuestion-1])
               {
                
                //save the corrects answers in php sessions
                     if(null === $correctAnswers = $app['session']->get('correctAnswers'))
                                    {
                                     
                                        $app['session']->set('correctAnswers', []);
                                    }
                                    
                         //when user click on the button use POST METHOD
                          if($request->getMethod() == "POST")
     {                    {
                           //create a session value
                        
                         
                         //user's input 
                             $questionNum=$request->get('numQuestion');
                             $questionAnswer=$request->get('answer');
                             
                             
                         //db inputs
                             $correctAns = $questions[$questionNum-1]->getCorrectAnswer();
                         
                      //debug   print_r(array("qn:"=>$questionNum,"ca"=>$correctAns,"ans"=>$questionAnswer));
                  
                         
                             //save if the answer correspond to answer
                              $correctAnswers[] = ($correctAns == $questionAnswer)?true:false;
                             
                             
                             
                              $finished=$numberOfQuestions <= count($correctAnswers);
                              
                              
                              //if last question : clear session
                              if($finished)
                                   $app['session']->clear();
                               else
                                    $app['session']->set('correctAnswers', $correctAnswers);
                         
     }                    }
           
       
   
                 return $app['twig']->render('test.html.twig', array('question' =>  $question,'category'=>$category,'numTest'=>$numTest,'numQuestion'=>$numQuestion,'numberOfQuestions'=>$numberOfQuestions,'correctAnswers'=>$correctAnswers,'finished'=>$finished));
   
               }
               
               
           }
           
          $app['session']->clear();
     
            return $app->redirect($app["url_generator"]->generate("quizz_home"));
           
   

    }
    }
 
}