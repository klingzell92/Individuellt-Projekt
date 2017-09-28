<?php

namespace Anax\Login\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \Anax\Login\Login;

/**
 * Example of FormModel implementation.
 */
class LoginForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Logga in"
            ],
            [
                "user" => [
                    "type"        => "text",
                    "class"       => "input",
                    //"description" => "Here you can place a description.",
                    "placeholder" => "Användarnamn",
                ],

                "password" => [
                    "type"        => "password",
                    "class"       => "input",
                    //"description" => "Here you can place a description.",
                    "placeholder" => "Lösenord",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Logga in",
                    "class" => "loginButton",
                    "callback" => [$this, "callbackSubmit"]
                ],
            ]
        );
    }



    /**
     * Callback for submit-button which should return true if it could
     * carry out its work and false if something failed.
     *
     * @return boolean true if okey, false if something went wrong.
     */
    public function callbackSubmit()
    {
        // Get values from the submitted form
        $acronym       = $this->form->value("user");
        $password      = $this->form->value("password");

        $login = new Login();
        $login->setDb($this->di->get("db"));
        $res = $login->verifyPassword($acronym, $password);

        if (!$res) {
           $this->form->rememberValues();
           $this->form->addOutput("User or password did not match.");
           return false;
        }

        //$this->form->addOutput("User " . $login->acronym . " logged in.");
        $this->di->get("session")->set("user", $acronym);
        $this->di->get("response")->redirect("profile");
        return true;
    }
}
