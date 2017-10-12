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

            $session->set("quizStart", time());
            if (!$session->has("quizCountTo")) {
                $session->set("quizCountTo", strtotime("+5 minutes"));

                $questions = $quiz->getQuestions($course, $test);
                $random = $quiz->shuffleQuestions($questions);
                array_splice($random, 5);
                $session->set("questions", $random);
                $session->set("pagination", array_keys($random));
                $session->set("page", 0);
            }

            $data = [
                "course"  => $course,
                "test"    => $test,
            ];

            $view->add("quiz/quiz", $data);

            $pageRender->renderPage(["title" => $title]);

        } else {
            $this->di->get("response")->redirect("login");
        }
    }

    /**
     * Show next question in quiz
     *
     *
     * @return void
     */
    public function incrementQuiz()
    {
        $session = $this->di->get("session");
        if ($session->has("user")) {
            $currentPage = $session->get("page");
            $session->set("page", $currentPage + 1);

            $course = $_POST["course"];
            unset($_POST["course"]);
            $test = $_POST["test"];
            unset($_POST["test"]);
            if (!$session->has("answers")) {
                $session->set("answers", $_POST);
                var_dump($session->get("answers"));
            } else {
                $this->addAnswer($_POST);
                var_dump($session->get("answers"));
            }
            $this->showTest($course, $test);
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
            $questions = $quiz->getQuestions($course, $test);

            $this->addAnswer($_POST);
            $answers = $session->get("answers");
            $session->delete("answers");

            $result = $quiz->getResult($answers, $questions);
            $session->delete("quizCountTo");
            $session->set("quizEnd", time());
            $seconds = $session->get("quizEnd") - $session->get("quizStart");
            $session->delete("quizStart");
            $session->delete("quizEnd");
            $time = $quiz->convert($seconds);
            $this->showResult($questions, $course, $test, $answers, $result, $time);
            //$quiz->addResult($user, $course, $test, $result, $time, 1, $_POST)
        } else {
            $this->di->get("response")->redirect("login");
        }
    }

    public function showResult($questions, $course, $test, $answers, $result, $time)
    {
        $session = $this->di->get("session");
        if ($session->has("user")) {
            $view       = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
            $title      = "$course $test";

            $data = [
                "questions" => $questions,
                "course"  => $course,
                "test"    => $test,
                "answers" => $answers,
                "result"  => $result,
                "time"    => $time,
            ];

            $view->add("quiz/result", $data);

            $pageRender->renderPage(["title" => $title]);
        } else {
            $this->di->get("response")->redirect("login");
        }
    }


    /**
    * Function to add an answer to an array of answers in the session
    * @return void
    */
    public function addAnswer($answer)
    {
        $session = $this->di->get("session");
        $answers = $session->get("answers");
        $key = array_keys($answer);
        $answers[$key[0]] = $answer[$key[0]];
        $session->set("answers", $answers);
    }

}
