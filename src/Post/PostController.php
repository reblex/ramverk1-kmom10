<?php

namespace reblex\Post;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \reblex\User\User;
use \reblex\Comment\Comment;
use \reblex\Post\Post;
use \reblex\Post\HTMLForm\CreatePostForm;
use \reblex\Post\HTMLForm\CreatePostCommentForm;

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
     * Show all items.
     *
     * @return void
     */
    public function getSpecific($postId)
    {
        // Get the post, based on ID from url
        $post = new Post();
        $post->setDb($this->di->get("db"));
        $post->find("id", $postId);

        $title      = "Post $post->id";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $account = $this->di->get("session")->get("account") ?: "";
        $currentUserRights = "none";

        // Comments will contain all commments related to the post
        $comments = new Comment();
        $comments->setDb($this->di->get("db"));
        $comments = $comments->findAllWhere("postId = ?", $postId);



        // Generate comment tree
        $tree = array();
        $rootComments = 0;
        for ($i=0; $i < count($comments); $i++) {
            // If comment has parent
            if (isset($comments[$i]->parentCommentId)) {
                // Find the parent location
                for ($j=0; $j < count($tree); $j++) {
                    if (isset($tree[$j][0])) {
                        for ($k=0; $k < count($tree[$j]); $k++) {
                            if ($tree[$j][$k]->id == $comments[$i]->parentCommentId) {
                                // Add the comment to the parents array
                                array_push($tree[$j], $comments[$i]);
                                break;
                            }
                        }
                    }
                }
            } else {
                $tree[$rootComments] = array();
                array_push($tree[$rootComments], $comments[$i]);
                $rootComments++;
            }
        }

        if ($account != "") {
            $user = new User();
            $user->setDb($this->di->get("db"));
            $user->find("username", $account);
            $currentUserRights = $user->admin == 1 ? "admin" : "user";
        }

        $data = [
            "post" => $post,
            "currentAccount" => $account,
            "currentUserRights" => $currentUserRights,
            "comments" => $tree
        ];

        $view->add("posts/specific", $data);

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

    public function getPostNewComment($postId, $parentId=-1)
    {
        // Render login page if not logged in.
        if (!$this->di->get("session")->has("account")) {
            $this->di->get("response")->redirect("user/login");
        }

        $title      = "New Comment";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user = new User();
        $username = $this->di->get("session")->get("account");
        $user->setDb($this->di->get("db"));
        $user->find("username", $username);

        $post = new Post();
        $post->setDb($this->di->get("db"));
        $post->find("id", $postId);

        $form = new CreatePostCommentForm($this->di, $user, $post, $parentId);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("posts/newComment", $data);

        $pageRender->renderPage(["title" => $title]);
    }

}
