<?php

namespace Anax\Quiz;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Anax\Quiz\Quiz;

/**
 * A controller for the Comment module
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class QuizController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
     * Render index page
     *
     *
     * @return void
     */
    public function getIndex()
    {
        $json = file_get_contents("../config/quiz.json");
        $title      = "A index page";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $data = [
            "content" => json_decode($json),
        ];
        $view->add("quiz/index", $data);

        $pageRender->renderPage(["title" => $title]);

    }
    /**
     * Render index page
     *
     *
     * @return void
     */
    public function showTest($course, $test)
    {
        $quiz = $this->di->get("quiz");
        $title      = "$course $test";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $questions = $quiz->getQuestions($course, $test);
        $random = $quiz->shuffle_questions($questions);
        array_splice($random, 5);

        $data = [
            "content" => $random,
            "course"  => $course,
            "test"    => $test,
        ];

        $_SESSION['quizStart'] = time();
        $view->add("quiz/quiz", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    /**
     * Handle submit of test
     *
     *
     * @return void
     */
    public function handlePostQuiz()
    {
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $quiz = $this->di->get("quiz");
        $course = $_POST["course"];
        unset($_POST["course"]);
        $test = $_POST["test"];
        unset($_POST["test"]);

        $title      = "$course $test";
        $questions = $quiz->getQuestions($course, $test);

        $result = $quiz->getResult($_POST, $questions);

        $_SESSION['quizEnd'] = time();
        $time = $_SESSION['quizEnd'] - $_SESSION['quizStart'];
        $data = [
            "questions" => $questions,
            "course"  => $course,
            "test"    => $test,
            "answers" => $_POST,
            "result"  => $result,
            "time"    => $time,
        ];

        $view->add("quiz/result", $data);

        $pageRender->renderPage(["title" => $title]);
    }
}
