<?php

namespace reblex\Comment;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \reblex\User\User;
use \reblex\Comment\Comment;
use \Anax\Comment\HTMLForm\CreateCommentForm;
use \Anax\Comment\HTMLForm\EditCommentForm;

/**
 * Comment Controller.
 */
class CommentController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
     * Show all items.
     *
     * @return void
     */
    public function getIndex()
    {
        $title      = "A collection of items";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $comment = new Comment();
        $comment->setDb($this->di->get("db"));

        $account = $this->di->get("session")->get("account") ?: "";
        $currentUserRights = "none";

        if ($account != "") {
            $user = new User();
            $user->setDb($this->di->get("db"));
            $user->find("username", $account);
            $currentUserRights = $user->admin == 1 ? "admin" : "user";
        }

        $data = [
            "comments" => $comment->findAll(),
            "currentAccount" => $account,
            "currentUserRights" => $currentUserRights
        ];

        $view->add("comments/view-all", $data);

        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return void
     */
    public function getPostNewComment()
    {
        // Render login page if not logged in.
        if (!$this->di->get("session")->has("account")) {
            $this->di->get("response")->redirect("user/login");
        }

        $title      = "Create a comment";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user = new User();
        $username = $this->di->get("session")->get("account");
        $user->setDb($this->di->get("db"));
        $user->find("username", $username);

        $form = new CreateCommentForm($this->di, $user);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("comments/new", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    /**
     * Handler with form to edit a comment.
     *
     * @return void
     */
    public function getPostEditComment($id)
    {
        // Render login page if not logged in.
        if (!$this->di->get("session")->has("account")) {
            $this->di->get("response")->redirect("user/login");
        }

        $title      = "Create a comment";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user = new User();
        $username = $this->di->get("session")->get("account");
        $user->setDb($this->di->get("db"));
        $user->find("username", $username);

        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->find("id", $id);

        // Not that users comment, and not admin
        if ($comment->userId != $user->id && $user->admin != 1) {
            $this->di->get("response")->redirect("comments");
        }

        $form = new EditCommentForm($this->di, $comment);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("comments/new", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    /**
     * Handler with form to edit a comment.
     *
     * @return void
     */
    public function getDeleteComment($id)
    {
        // Render login page if not logged in.
        if (!$this->di->get("session")->has("account")) {
            $this->di->get("response")->redirect("user/login");
        }

        $user = new User();
        $username = $this->di->get("session")->get("account");
        $user->setDb($this->di->get("db"));
        $user->find("username", $username);

        $comment = new Comment();
        $comment->setDb($this->di->get("db"));
        $comment->find("id", $id);

        // Not that users comment, and not admin
        if ($comment->userId != $user->id && $user->admin != 1) {
            $this->di->get("response")->redirect("comments");
        }

        $comment->delete();

        $this->di->get("response")->redirect("comments");
    }
}
