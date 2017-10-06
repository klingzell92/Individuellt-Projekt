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
        $session = $this->di->get("session");
        if ($session->has("user")) {
            $json = file_get_contents("../config/quiz.json");
            $title      = "A index page";
            $view       = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");

            $data = [
                "content" => json_decode($json),
            ];
            $view->add("quiz/index", $data);

            $pageRender->renderPage(["title" => $title]);
        } else {
            $this->di->get("response")->redirect("login");
        }
    }
    /**
     * Render index page
     *
     *
     * @return void
     */
    public function showTest($course, $test)
    {
        $session = $this->di->get("session");
        if ($session->has("user")) {
            $quiz = new Quiz();
            $quiz->setDb($this->di->get("db"));
            $title      = "$course $test";
            $view       = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
            $questions = $quiz->getQuestions($course, $test);
            $random = $quiz->shuffleQuestions($questions);
            array_splice($random, 5);

            $data = [
                "content" => $random,
                "course"  => $course,
                "test"    => $test,
            ];

            $_SESSION['quizStart'] = time();
            $view->add("quiz/quiz", $data);

            $pageRender->renderPage(["title" => $title]);
        } else {
            $this->di->get("response")->redirect("login");
        }
    }

    /**
     * Handle submit of test
     *
     *
     * @return void
     */
    public function handlePostQuiz()
    {
        $session = $this->di->get("session");
        if ($session->has("user")) {
            $view       = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
            $quiz = new Quiz();
            $quiz->setDb($this->di->get("db"));


            $course = $_POST["course"];
            unset($_POST["course"]);
            $test = $_POST["test"];
            unset($_POST["test"]);
            $user = $session->get("user");
            $title      = "$course $test";
            $questions = $quiz->getQuestions($course, $test);

            $result = $quiz->getResult($_POST, $questions);

            $_SESSION['quizEnd'] = time();
            $time = $_SESSION['quizEnd'] - $_SESSION['quizStart'];

            //$quiz->addResult($user, $course, $test, $result, $time, 1, $_POST)
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
        } else {
            $this->di->get("response")->redirect("login");
        }
    }
}
