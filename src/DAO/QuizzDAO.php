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
        $sql="select DISTINCT Category from ".$dbName;
        $result = $this->db->fetchAll($sql);
        
        $categories = [];
        foreach($categories as $category)
        {
            $categories[] = $this->buildCategory($category);
        }
        
        return $categories;
      
    }
    
    public function buildCategory($categoryName)
    {
        $category = new Category();
        $category->setName($categoryName);
        return $category;
    }
    
    
}