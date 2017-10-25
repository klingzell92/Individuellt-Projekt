<?php

namespace Anax\Login;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \Anax\Login\HTMLForm\LoginForm;

/**
 * A controller class.
 */
class LoginController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
        InjectionAwareTrait;

    /**
     * Returns an index page
     *
     * @return void
     */
    public function getIndex()
    {
        $title      = "A index page";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $data = [
            "content" => "An index page",
        ];

        $view->add("default2/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * Returns the login form and handles login.
     *
     * @return void
     */
    public function getPostLogin()
    {
        $title      = "A login page";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new LoginForm($this->di);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $view->add("login/login", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    /**
    * Logout user
    *
    * @return void
    */
    public function logOutUser()
    {
        $this->di->get("session")->destroy();
        $this->di->get("response")->redirect("login");
    }
}
