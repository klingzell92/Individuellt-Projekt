<?php

namespace Anax\Quiz;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A controller for the Comment module
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class Quiz implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    /*
    * Function to randomize the questions but keep the keys
    */
    public function shuffle_questions($questions)
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
