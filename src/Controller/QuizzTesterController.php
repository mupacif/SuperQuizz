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
               
    
            //get all questions
               $questions = $test-> getQuestions();
               
               
               //show test only if number of question is smaller than the count of all tests
               $numberOfQuestions = count($questions);
               
               if( $numberOfQuestions >= $numQuestion )
               {
                   //get the question
                   if( null !== $question = $questions[$numQuestion-1])
                   {
                    
                    //save the corrects answers in php sessions
                    //or create the session if it's the first time 
                         if(null === $correctAnswers = $app['session']->get('correctAnswers'))
                                        {
                                         
                                            $app['session']->set('correctAnswers', []);
                                        }
                                        
                             //when user click on the button use POST METHOD
                              if($request->getMethod() == "POST")
         {                    {
                               //create a session value
                            
                             
                             //user's input 
                                 $questionNum=$request->get('questionNumber');
                                 $questionAnswer=$request->get('answer');
                                 
                                 
                             //db inputs
                                 $correctAns = $questions[$questionNum-1]->getCorrectAnswer();
                             
                         
                            //  print_r(array("user:number of the question:"=>$questionNum,"correct answer db"=>$correctAns,"user:user answer"=>$questionAnswer));
                
                             
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