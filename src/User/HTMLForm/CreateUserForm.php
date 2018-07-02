<?php

namespace Anax\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \reblex\User\User;

/**
 * Example of FormModel implementation.
 */
class CreateUserForm extends FormModel
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
                "legend" => "Create user",
            ],
            [
                "username" => [
                    "type"        => "text",
                ],

                "email" => [
                    "type"        => "email",
                ],

                "password" => [
                    "type"        => "password",
                ],
                "password-again" => [
                    "type"        => "password",
                    "validation" => [
                        "match" => "password"
                    ],
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Create user",
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
        $username       = $this->form->value("username");
        $email          = $this->form->value("email");
        $password       = $this->form->value("password");
        $passwordAgain  = $this->form->value("password-again");

        // Check password matches
        if ($password !== $passwordAgain) {
            $this->form->rememberValues();
            $this->form->addOutput("Password did not match.");
            return false;
        }

        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->username = $username;
        $user->email = $email;
        $user->admin = 0;
        $user->setPassword($password);
        try {
            $user->save();
        } catch (\Exception $e) {
            $this->form->addOutput("Användarnamn/Email används redan!");
            $this->form->rememberValues();
            return false;
        }

        $this->form->addOutput("User was created.");
        return true;
    }
}
