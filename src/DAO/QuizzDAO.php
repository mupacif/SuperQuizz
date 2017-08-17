<?php

namespace Quizz\DAO;

use Doctrine\DBAL\Connection;
use Quizz\Domain\Category;
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
    
    public function findAll()
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
    
    
}