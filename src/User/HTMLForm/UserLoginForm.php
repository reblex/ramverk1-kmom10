<?php

namespace Anax\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \reblex\User\User;

/**
 * Example of FormModel implementation.
 */
class UserLoginForm extends FormModel
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
                "legend" => "User Login"
            ],
            [
                "user" => [
                    "type"        => "text",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "password" => [
                    "type"        => "password",
                    //"description" => "Here you can place a description.",
                    //"placeholder" => "Here is a placeholder",
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Login",
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
        $username       = $this->form->value("user");
        $password       = $this->form->value("password");

        $user = new User();
        $user->setDb($this->di->get("db"));
        $res = $user->verifyPassword($username, $password);

        if (!$res) {
            $this->form->rememberValues();
            $this->form->addOutput("User and password did not match.");
            return false;
        }

        $this->di->get("session")->set("account", $username);
        $this->di->get("response")->redirect("user");
    }
}
