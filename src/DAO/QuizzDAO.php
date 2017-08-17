<?php

namespace Quizz\DAO;

use Doctrine\DBAL\Connection;
use Quizz\Domain\Category;
use Quizz\Domain\Test;
use Quizz\Domain\Question;
class QuizzDAO
{
    /**
     * our database
     */
    private $db;

    public static $dbName = "maindb";
    public static $nameCategory = "Category";
    public static $nameNumTest = "Num_test";
    public static $nameNumQuestion = "Num_question";
    public static $nameQuantityAns = "Quantity_ans";
    public static $nameNumCorrectAns = "Num_correct_ans";


    public function __construct(Connection $db)
    {
        $this->db=$db;
    }

    /***
     * Function to get all questions of a test in a given category
     * @param $category the category of the test
     * @param $numTest the number of the test
     */
    public function getQuestionsOf($category,$numTest)
    {
        $sql = "SELECT * FROM ".QuizzDAO::$dbName." where ".QuizzDAO::$nameCategory." = '".$category."' AND ".QuizzDAO::$nameNumTest." = ".$numTest;
        $results = $this->db->fetchAll($sql);
        $test = new Test();
        $test->setCategory($category);
        $test->setNumTest($numTest);

        $questions = [];
        foreach($results as $questionsArray)
        {
            $questions[] = $this->buildQuestion($questionsArray);

        }

        $test->setQuestions($questions);
        return $questions;
    }

    /***
     * @return array list of all categories
     */
    public function getAllCategories()
    {
        $sqlSelectAllCategories ="SELECT DISTINCT ".QuizzDAO::$nameCategory." FROM ".QuizzDAO::$dbName;

        $results = $this->db->fetchAll($sqlSelectAllCategories);
        
        $categories = [];
        foreach($results as $categoryArray)
        {
            $category = $this->buildCategory($categoryArray);
            $category->setTests($this->getAllTestsOfCategory($category->getName()));
            $categories[] = $category;
        }
        
        return $categories;
      
    }

    public function getAllCategoriesName()
    {
        $sqlSelectAllCategories ="SELECT DISTINCT ".QuizzDAO::$nameCategory." FROM ".QuizzDAO::$dbName;

        $results = $this->db->fetchAll($sqlSelectAllCategories);

        $categories = [];
        foreach($results as $categoryArray)
        {

            $categories[] = $categoryArray['Category'];
        }

        return $categories;

    }


    public function getAllTestsOfCategory($name)
    {
        $sqlSelectAllTestsOfACategory = "SELECT DISTINCT ".QuizzDAO::$nameNumTest." FROM ".QuizzDAO::$dbName." WHERE Category ='{$name}'";
        $results = $this->db->fetchAll($sqlSelectAllTestsOfACategory);

        $tests = [];
        foreach($results as $testArray) {
            $tests[] = $testArray[QuizzDAO::$nameNumTest];
        }
        return $tests;
    }
    
    public function buildCategory(array $categoryName)
    {
        $category = new Category();
        $category->setName($categoryName[QuizzDAO::$nameCategory]);
        return $category;
    }
    public function buildQuestion(array $questionArray)
    {
        $numberFormat = sprintf("%03d%02d",$questionArray[QuizzDAO::$nameNumTest],$questionArray[QuizzDAO::$nameNumQuestion]);

    
       // $addr = $questionArray[QuizzDAO::$nameCategory].$questionArray[QuizzDAO::$nameNumTest].$questionArray[QuizzDAO::$nameNumQuestion].$questionArray[QuizzDAO::$nameQuantityAns].$questionArray[QuizzDAO::$nameNumCorrectAns].".jpg";

        $addr = $questionArray[QuizzDAO::$nameCategory].$numberFormat.$questionArray[QuizzDAO::$nameNumCorrectAns].$questionArray[QuizzDAO::$nameQuantityAns].".jpg";


        $numQuestion = $questionArray[QuizzDAO::$nameNumQuestion];
        $quantityAns = $questionArray[QuizzDAO::$nameQuantityAns];
        $correctAns = $questionArray[QuizzDAO::$nameNumCorrectAns];

        $question = new Question();
        $question->setAddr($addr);
        $question->setNumQuestion($numQuestion);
        $question->setQuantityAns($quantityAns);
        $question->setCorrectAnswer($correctAns);
        return $question;
    }
    
    
}