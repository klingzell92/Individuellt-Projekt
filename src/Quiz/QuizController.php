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
        $json = file_get_contents("../config/quiz.json");
        $title      = "$course $test";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $content = json_decode($json, true);
        shuffle($content);


        $data = [
            "content" => $content[$course][$test],
            "course"  => $course,
            "test"    => $test,
            "random"  => $questions,
        ];

        $view->add("quiz/quiz", $data);

        $pageRender->renderPage(["title" => $title]);

        var_dump($course);
    }

}
