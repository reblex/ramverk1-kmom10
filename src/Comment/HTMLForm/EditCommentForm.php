<?php

namespace Anax\Comment\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \reblex\Comment\Comment;

/**
 * Example of FormModel implementation.
 */
class EditCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $comment)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__,
                "legend" => "Update details of the item",
            ],
            [
                "id" => [
                    "type" => "hidden",
                    "value" => $comment->id,
                ],
                "comment" => [
                    "type" => "textarea",
                    "value" => $comment->content,
                ],
                "submit" => [
                    "type" => "submit",
                    "value" => "Save",
                    "callback" => [$this, "callbackSubmit"]
                ],

                "reset" => [
                    "type"      => "reset",
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
        $comment->find("id", $this->form->value("id"));
        $comment->content = $this->form->value("comment");
        $comment->save();
        $this->di->get("response")->redirect("comments");
    }
}
