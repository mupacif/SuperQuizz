<?php

namespace Quizz\Domain;

class Test
{
    
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
    
}