<?php

namespace Quizz\Domain;

class Category
{
    private $name;
    private $tests;
    
    public function getName()
    {
        return $this->name;
    }
    
    
        public function getTests()
    {
        return $this->tests;
    }
    
    
        public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    
        public function setTests($tests)
    {
         $this->tests = $tests;
        return $this;
    }
    
    
}