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
    public $times_test_done;
    public $questions;
    public $answers;
    public $created;
    public $updated;
    public $deleted;
    public $active;


    /**
     * Add a comment to the session.
     *
     * @param string $user
     * @param string $course
     * @param string $test
     * @param string $result
     * @param string $time
     * @param string $time_test_done
     * @param string $answers
     *
     * @return void
     */

    public function addResult($user, $course, $test, $result, $time, $answers, $questions)
    {
        // Needs to be first if there is a result, so all previous values can be replaced
        $quizColumn = $this->findAllWhere("acronym = ? and course = ? and test = ?", [$user, $course, $test]);
        $lastColumn = end($quizColumn);
        $this->acronym  = $user;
        $this->course = $course;
        $this->test = $test;
        $this->result = $result;
        $this->time = $time;
        $this->times_test_done = 1;
        if ($quizColumn) {
            $this->id = null;
            $this->times_test_done = $lastColumn->times_test_done + 1;
        } else {
            //var_dump($course);
            $this->times_test_done = 1;
        }

        $newAnswers = "";
        $newQuestions = "";
        foreach ($answers as $key => $answer) {
            $newAnswers .= $answer . ", ";
            $newQuestions .= $questions[$key]["question"] . ", ";
        }

        $this->answers = $newAnswers;
        $this->questions = $newQuestions;
        $this->save();
    }

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


    /*
    * Function to get the result
    */
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

    /**
    * Function for converting seconds into minutes:seconds
    * @return string
    */
    function convert($iSeconds)
    {
        $min = intval($iSeconds / 60);
        return $min . ':' . str_pad(($iSeconds % 60), 2, '0', STR_PAD_LEFT);
    }


}
