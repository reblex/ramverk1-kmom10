<?php

namespace Anax\User\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \reblex\User\User;

/**
 * Example of FormModel implementation.
 */
class EditUserAdminForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $user)
    {
        parent::__construct($di);
        $isAdmin = $user->admin == 1 ? true : false;

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update details of the item",
            ],
            [
                "id" => [
                    "type" => "hidden",
                    "value" => $user->id,
                ],
                "username" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->username,
                ],

                "email" => [
                    "type" => "text",
                    "validation" => ["not_empty"],
                    "value" => $user->email,
                ],
                "admin" => [
                    "type"        => "checkbox",
                    "label"       => "Admin",
                    "checked"     => $isAdmin
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
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
        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("id", $this->form->value("id"));
        $user->username = $this->form->value("username");
        $user->email = $this->form->value("email");
        $user->admin = $this->form->value("admin") == true ? 1 : 0;

        try {
            $user->save();
        } catch (\Exception $e) {
            $this->form->addOutput("Användarnamn/Email används redan!");
            $this->form->rememberValues();
            return false;
        }

        $this->di->get("session")->set("account", $user->username);
        $this->di->get("response")->redirect("user/admin");
        return true;
    }
}
