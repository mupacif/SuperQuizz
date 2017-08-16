<?php

namespace Quizz\Domain;

class Test
{
    
    private $questions;
    
    public getQuestions()
    {
        return $this->questions;
    }
    
       public setQuestions($questions)
    {
        $this->questions=$questions;
        return $this;
    }
    
}