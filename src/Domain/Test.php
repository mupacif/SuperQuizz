<?php

namespace Quizz\Domain;

class Test
{
    private $category;
    private $numTest;
    private $questions;
    
    public function getQuestions()
    {
        return $this->questions;
    }
    
       public function setQuestions($questions)
    {
        $this->questions=$questions;
        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($categoryName)
    {
        $this->category = $categoryName;
        return $this;
    }

    public function getNumTest()
    {
        return $this->numTest;
    }

    public function setNumTest($numTest)
    {
        $this->numTest = $numTest;
        return $this;
    }
    
}