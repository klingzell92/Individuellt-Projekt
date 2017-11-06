<?php

namespace Anax\Quiz;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\Quiz\Quiz;

/**
 * A controller for the Comment module
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class QuizController implements InjectionAwareInterface
{
    use InjectionAwareTrait;
    use ConfigureTrait;

    /**
     * Render index page with links to all the tests
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
     * Show a test
     *
     * @param string $course
     * @param string $test
     * @return void
     */
    public function showTest($course, $test)
    {
        $session = $this->di->get("session");
        if ($session->has("user")) {
            $quiz = new Quiz();
            $quiz->setDb($this->di->get("db"));
            $timesTestDone = 0;
            $user = $session->get("user");
            $result = $quiz->findAllWhere("acronym = ? and course = ? and test = ?", [$user, $course, $test]);
            $lastResult = end($result);

            if ($result) {
                $timesTestDone = $lastResult->times_test_done;
            }

            $title      = "$course $test";
            $view       = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");

            if ($timesTestDone < $this->config["maxTest"]) {
                if (!$session->has("quizCountTo")) {
                    $session->set("quizStart", time());
                    $session->set("quizCountTo", strtotime($this->config["maxTimeTest"]));

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
                $data = [
                    "course"  => $course,
                    "test"    => $test,
                ];

                $view->add("quiz/stop", $data);

                $pageRender->renderPage(["title" => $title]);
            }
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

            $course = $_POST["course"];
            unset($_POST["course"]);
            $test = $_POST["test"];
            unset($_POST["test"]);
            if (!$session->has("answers")) {
                $session->set("answers", $_POST);
                //var_dump($session->get("answers"));
            } else {
                $this->addAnswer($_POST);
                //var_dump($session->get("answers"));
            }

            if ($currentPage < 4) {
                $session->set("page", $currentPage + 1);
                $this->showTest($course, $test);
            } else {
                $session->set("page", $currentPage + 1);
                $this->showAnswers($course, $test);
            }
        } else {
            $this->di->get("response")->redirect("login");
        }
    }

    /**
     * Show previous question in quiz
     *
     *  @param string $course
     *  @param string $test
     *
     * @return void
     */
    public function decrementQuiz($course, $test)
    {
        $session = $this->di->get("session");
        if ($session->has("user")) {
            $currentPage = $session->get("page");
            if ($currentPage > 0) {
                $session->set("page", $currentPage - 1);
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
        $db = $this->di->get("db");
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
            if ($_POST) {
                $this->addAnswer($_POST);
            }
            $answers = $session->get("answers");
            $session->delete("answers");

            $result = $quiz->getResult($answers, $questions);
            $session->delete("quizCountTo");
            $session->set("quizEnd", time());
            $seconds = $session->get("quizEnd") - $session->get("quizStart");
            $session->delete("quizStart");
            $session->delete("quizEnd");
            $time = $quiz->convert($seconds);
            $quiz->addResult($user, $course, $test, $result, $time, $answers, $questions);
            $this->di->get("response")->redirect("quiz/result/$user/$course/$test");
        } else {
            $this->di->get("response")->redirect("login");
        }
    }

    /**
    * Show the answers before student submits the test
    *
    * @param string $course
    * @param string $test
    *
    * @return void
    */
    public function showAnswers($course, $test)
    {
        $session = $this->di->get("session");
        if ($session->has("user")) {
            $quiz = new Quiz();
            $quiz->setDb($this->di->get("db"));
            $view       = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
            $title      = "$course $test";
            $answers = $session->get("answers");
            $questions = $quiz->getQuestions($course, $test);


            $data = [
                "questions" => $questions,
                "course"  => $course,
                "test"    => $test,
                "answers" => $answers,
            ];

            $view->add("quiz/show", $data);

            $pageRender->renderPage(["title" => $title]);
        } else {
            $this->di->get("response")->redirect("login");
        }
    }

    /**
    * Show the result on the test with all the answers
    *
    * @param string $course
    * @param string $test
    *
    * @return void
    */
    public function showResult($user, $course, $test)
    {
        $session = $this->di->get("session");
        if ($session->has("user")) {
            $quiz = new Quiz();
            $quiz->setDb($this->di->get("db"));
            $result = $quiz->findAllWhere("acronym = ? and course = ? and test = ?", [$user, $course, $test]);
            $lastResult = end($result);
            //var_dump($result);

            $view       = $this->di->get("view");
            $pageRender = $this->di->get("pageRender");
            $title      = "$course $test";
            $data = [
                "questions" => explode(", ", $lastResult->questions),
                "course"  => $course,
                "test"    => $test,
                "answers" => explode(", ", $lastResult->answers),
                "result"  => $lastResult->result,
                "time"    => $lastResult->time,
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
