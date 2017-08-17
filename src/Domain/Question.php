<?php
/**
 * Created by PhpStorm.
 * User: mupac_000
 * Date: 17-08-17
 * Time: 18:16
 */

namespace Quizz\Domain;


class Question
{
private $addr;
private $numQuestion;
private $quantityAns;
private $correctAnswer;

    /**
     * @return mixed
     */
    public function getAddr()
    {
        return $this->addr;
    }

    /**
     * @param mixed $addr
     */
    public function setAddr($addr)
    {
        $this->addr = $addr;
    }

    /**
     * @return mixed
     */
    public function getNumQuestion()
    {
        return $this->numQuestion;
    }

    /**
     * @param mixed $numQuestion
     */
    public function setNumQuestion($numQuestion)
    {
        $this->numQuestion = $numQuestion;
    }

    /**
     * @return mixed
     */
    public function getQuantityAns()
    {
        return $this->quantityAns;
    }

    /**
     * @param mixed $quantityAns
     */
    public function setQuantityAns($quantityAns)
    {
        $this->quantityAns = $quantityAns;
    }

    /**
     * @return mixed
     */
    public function getCorrectAnswer()
    {
        return $this->correctAnswer;
    }

    /**
     * @param mixed $correctAnswer
     */
    public function setCorrectAnswer($correctAnswer)
    {
        $this->correctAnswer = $correctAnswer;
    }


}