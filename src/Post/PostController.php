<?php

namespace reblex\Post;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \reblex\User\User;
use \reblex\Comment\Comment;
use \reblex\Post\Post;
use \reblex\Post\HTMLForm\CreatePostForm;
// use \reblex\Post\HTMLForm\EditCommentForm;

/**
 * Post Controller.
 */
class PostController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
     * Show all items.
     *
     * @return void
     */
    public function getIndex()
    {
        $title      = "Posts";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $post = new Post();
        $post->setDb($this->di->get("db"));

        $account = $this->di->get("session")->get("account") ?: "";
        $currentUserRights = "none";

        if ($account != "") {
            $user = new User();
            $user->setDb($this->di->get("db"));
            $user->find("username", $account);
            $currentUserRights = $user->admin == 1 ? "admin" : "user";
        }

        $data = [
            "posts" => $post->findAll(),
            "currentAccount" => $account,
            "currentUserRights" => $currentUserRights
        ];

        $view->add("posts/view-all", $data);

        $pageRender->renderPage(["title" => $title]);
    }



    /**
     * Handler with form to create a new item.
     *
     * @return void
     */
    public function getPostNewPost()
    {
        // Render login page if not logged in.
        if (!$this->di->get("session")->has("account")) {
            $this->di->get("response")->redirect("user/login");
        }

        $title      = "New Post";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user = new User();
        $username = $this->di->get("session")->get("account");
        $user->setDb($this->di->get("db"));
        $user->find("username", $username);

        $form = new CreatePostForm($this->di, $user);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("posts/new", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    // /**
    //  * Handler with form to edit a comment.
    //  *
    //  * @return void
    //  */
    // public function getPostEditComment($id)
    // {
    //     // Render login page if not logged in.
    //     if (!$this->di->get("session")->has("account")) {
    //         $this->di->get("response")->redirect("user/login");
    //     }
    //
    //     $title      = "Create a comment";
    //     $view       = $this->di->get("view");
    //     $pageRender = $this->di->get("pageRender");
    //
    //     $user = new User();
    //     $username = $this->di->get("session")->get("account");
    //     $user->setDb($this->di->get("db"));
    //     $user->find("username", $username);
    //
    //     $comment = new Comment();
    //     $comment->setDb($this->di->get("db"));
    //     $comment->find("id", $id);
    //
    //     // Not that users comment, and not admin
    //     if ($comment->userId != $user->id && $user->admin != 1) {
    //         $this->di->get("response")->redirect("comments");
    //     }
    //
    //     $form = new EditCommentForm($this->di, $comment);
    //
    //     $form->check();
    //
    //     $data = [
    //         "form" => $form->getHTML(),
    //     ];
    //
    //     $view->add("comments/new", $data);
    //
    //     $pageRender->renderPage(["title" => $title]);
    // }
    //
    // /**
    //  * Handler with form to edit a comment.
    //  *
    //  * @return void
    //  */
    // public function getDeleteComment($id)
    // {
    //     // Render login page if not logged in.
    //     if (!$this->di->get("session")->has("account")) {
    //         $this->di->get("response")->redirect("user/login");
    //     }
    //
    //     $user = new User();
    //     $username = $this->di->get("session")->get("account");
    //     $user->setDb($this->di->get("db"));
    //     $user->find("username", $username);
    //
    //     $comment = new Comment();
    //     $comment->setDb($this->di->get("db"));
    //     $comment->find("id", $id);
    //
    //     // Not that users comment, and not admin
    //     if ($comment->userId != $user->id && $user->admin != 1) {
    //         $this->di->get("response")->redirect("comments");
    //     }
    //
    //     $comment->delete();
    //
    //     $this->di->get("response")->redirect("comments");
    // }
}
