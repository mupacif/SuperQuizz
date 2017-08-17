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

    private $dbName = "maindb";
    
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
        $sql = "SELECT * FROM ".$this->dbName." where Category = '".$category."' AND Num_test = ".$numTest;
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
        $sqlSelectAllCategories ="SELECT DISTINCT Category FROM ".$this->dbName;

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
        $sqlSelectAllCategories ="SELECT DISTINCT Category FROM ".$this->dbName;

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
        $sqlSelectAllTestsOfACategory = "SELECT DISTINCT Num_test FROM ".$this->dbName." WHERE Category ='".$name."'";
        $results = $this->db->fetchAll($sqlSelectAllTestsOfACategory);

        $tests = [];
        foreach($results as $testArray) {
            $tests[] = $testArray['Num_test'];
        }
        return $tests;
    }
    
    public function buildCategory(array $categoryName)
    {
        $category = new Category();
        $category->setName($categoryName['Category']);
        return $category;
    }
    public function buildQuestion(array $questionArray)
    {
        $addr = "{$questionArray['Category']}{$questionArray['Num_test']}{$questionArray['Num_question']}{$questionArray['Quantity_ans']}{$questionArray['Num_correct_ans']}.jpg";
        $numQuestion = $questionArray['Num_question'];
        $quantityAns = $questionArray['Quantity_ans'];
        $correctAns = $questionArray['Num_correct_ans'];

        $question = new Question();
        $question->setAddr($addr);
        $question->setNumQuestion($numQuestion);
        $question->setQuantityAns($quantityAns);
        $question->setCorrectAnswer($correctAns);
        return $question;
    }
    
    
}