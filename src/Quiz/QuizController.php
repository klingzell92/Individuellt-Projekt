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
            "content" => json_decode($json, true),
        ];
        //$data = json_decode($json, true);
        //var_dump($data);
        //var_dump(json_last_error());

        $view->add("test/test", $data);

        $pageRender->renderPage(["title" => $title]);

    }

}
