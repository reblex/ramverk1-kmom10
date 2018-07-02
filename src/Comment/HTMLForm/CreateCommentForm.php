<?php

namespace Anax\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \reblex\Comment\Comment;
use \reblex\User\User;

/**
 * Example of FormModel implementation.
 */
class CreateCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $user)
    {
        parent::__construct($di);
        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Ny kommentar"
            ],
            [
                "userId" => [
                    "type"        => "hidden",
                    "value" => $user->id
                ],
                "comment" => [
                    "type"        => "textarea",
                    "description" => "Max 800 karaktärer."
                ],

                "submit" => [
                    "type" => "submit",
                    "value" => "Post",
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
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->userId  = $this->form->value("userId");
        $comment->content = $this->form->value("comment");
        $comment->save();

        $this->di->get("response")->redirect("comments");
    }
}
