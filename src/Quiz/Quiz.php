<?php

namespace Anax\Quiz;

use \Anax\Database\ActiveRecordModel;

/**
 * A database driven model.
 */
class Quiz extends ActiveRecordModel
{
    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "Quiz";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $id;
    public $acronym;
    public $course;
    public $test;
    public $result;
    public $time;
    public $times_test;
    public $answers;
    public $created;
    public $updated;
    public $deleted;
    public $active;


    /**
     * Add a comment to the session.
     *
     * @param string $username
     * @param string $comment
     * @param string $gravatar
     *
     * @return void
     */
     /*
    public function addResult($user, $course, $test, $result, $time, $times_test, $answers)
    {
        $this->acronym  = $user;
        $this->course = $course;
        $this->test = $test;
        $this->result = $result;
        $this->time = $time;
        $this->time_test = $times_test;

        //$this->save();
    }
    */
    /*
    * Function to randomize the questions but keep the keys
    */
    public function shuffleQuestions($questions)
    {
      if (!is_array($questions)) return $questions;

      $keys = array_keys($questions);
      shuffle($keys);
      $random = array();
      foreach ($keys as $key) {
        $random[$key] = $questions[$key];
      }
      return $random;
    }

    /*
    * Function to get questions for the specified test
    */
    public function getQuestions($course, $test)
    {
        $json = file_get_contents("../config/quiz.json");
        $content = json_decode($json, true);
        $questions = $content[$course][$test];
        return $questions;
    }

    public function getResult($answers, $questions)
    {
        $score = 0;
        foreach ($answers as $key => $answer) {
            if ($answer == $questions[$key]["correct"]) {
                $score++;
            }
        }
        return $score;
    }

}
