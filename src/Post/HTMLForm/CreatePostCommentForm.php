<?php

namespace reblex\Post\HTMLForm;

use \Anax\HTMLForm\FormModel;
use \Anax\DI\DIInterface;
use \reblex\Post\Post;
use \reblex\User\User;
use \reblex\Comment\Comment;

/**
 * Example of FormModel implementation.
 */
class CreatePostCommentForm extends FormModel
{
    /**
     * Constructor injects with DI container.
     *
     * @param Anax\DI\DIInterface $di a service container
     */
    public function __construct(DIInterface $di, $user, $post, $parentCommentId=-1)
    {
        parent::__construct($di);

        $this->form->create(
            [
                "id" => __CLASS__
            ],
            [
                "userId" => [
                    "type"        => "hidden",
                    "value"       => $user->id
                ],
                "postId" => [
                    "type"        => "hidden",
                    "value"       => $post->id
                ],
                "parentCommentId" => [
                    "type"        => "hidden",
                    "value"       => $parentCommentId
                ],

                "content" => [
                    "type"        => "textarea",
                    "class"       => "commentTextArea"
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
     * @return boolean false if error, else redirects.
     */
    public function callbackSubmit()
    {
        $db = $this->di->get("db");

        $dt = new \DateTime("now", new \DateTimeZone('Europe/Stockholm'));
        $postId = $this->form->value("postId");
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->userId = $this->form->value("userId");
        $comment->postId = $postId;
        $comment->parentCommentId = $this->form->value("parentCommentId") == -1 ? NULL : $this->form->value("parentCommentId");

        $comment->datetime = $dt->format("Y-m-d H:i:s");
        $comment->content = $this->form->value("content");

        $comment->save();

        $this->di->get("response")->redirect("posts/$postId");
    }
}
