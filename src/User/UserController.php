<?php

namespace reblex\User;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \reblex\Post\Post;
use \reblex\User\User;
use \reblex\Comment\Comment;
use \Anax\User\HTMLForm\UserLoginForm;
use \Anax\User\HTMLForm\EditUserForm;
use \Anax\User\HTMLForm\CreateUserForm;
use \Anax\User\HTMLForm\CreateUserAdminForm;
use \Anax\User\HTMLForm\EditUserAdminForm;

/**
 * A controller class.
 */
class UserController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
        InjectionAwareTrait;



    /**
     * @var $data description
     */
    //private $data;


    public function getIndex()
    {
        // Render login page if not logged in.
        if (!$this->di->get("session")->has("account")) {
            $this->di->get("response")->redirect("user/login");
        }

        $title      = "My Account";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user = new User();

        $username = $this->di->get("session")->get("account");
        $user->username = $username;
        $user->setDb($this->di->get("db"));
        $user->findWhere("username = ?", $username);


        $data = [
            "user" => $user,
        ];

        $view->add("user/index", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function getAllUsers()
    {
        $title      = "Users";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user = new User();
        $user->setDb($this->di->get("db"));


        $data = [
            "users" => $user->findAll(),
        ];

        $view->add("users/view-all", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function getSpecificUser($name)
    {
        $title      = $name;
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("username", $name);

        // Get all posts related with userId
        $userPosts = new Post();
        $userPosts->setDb($this->di->get("db"));
        $userPosts = $userPosts->findAllWhere("userId = ?", $user->id);

        // Save array of postIds for all posts from above
        $userPostIds = [];
        foreach ($userPosts as $post) {
            array_push($userPostIds, $post->id);
        }

        // Get all comments with userId
        $comments = new Comment();
        $comments->setDb($this->di->get("db"));
        $comments = $comments->findAllWhere("userId = ?", $user->id);

        // if comments postId isn't already in $userPostIds, add it
        // to this array to select all related posts not already found.
        $commentPostIds = [];
        foreach ($comments as $comment) {
            // if the post is't already fetched in userPosts...
            if (in_array($comment->postId, $userPostIds) == false) {
                array_push($commentPostIds, $comment->postId);
                array_push($userPostIds, $comment->postId);
            }
        }

        $relatedPost = new Post();
        $relatedPost->setDb($this->di->get("db"));

        $relatedPosts = [];
        foreach ($commentPostIds as $id) {
            array_push($relatedPosts, $relatedPost->find("id", $id));
        }

        $posts = array_merge($userPosts, $relatedPosts);

        $data = [
            "user" => $user,
            "relatedPosts" => $posts
        ];

        $view->add("users/specific", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function getIndexAdmin()
    {
        // Render login page if not logged in.
        if (!$this->di->get("session")->has("account")) {
            $this->di->get("response")->redirect("user/login");
        }

        $title      = "Admin";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user = new User();

        $username = $this->di->get("session")->get("account");
        $user->username = $username;
        $user->setDb($this->di->get("db"));
        $user->find("username", $username);

        $allUsers = new User();
        $allUsers->setDb($this->di->get("db"));

        $data = [
            "users" => $allUsers->findAll(),
        ];

        $view->add("user/adminIndex", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    public function getPostLogin()
    {
        $title      = "A login page";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new UserLoginForm($this->di);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $view->add("user/login", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    public function getLogout()
    {
        $session = $this->di->get("session");

        if ($session->has("account")) {
            $session->delete("account");
        }

        $this->di->get("response")->redirect("user/login");
    }

    /**
     * Handler with form to update an item.
     *
     * @return void
     */
    public function getPostEditUser()
    {
        // Render login page if not logged in.
        if (!$this->di->get("session")->has("account")) {
            $this->di->get("response")->redirect("user/login");
        }

        $title      = "Edit";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user = new User();
        $username = $this->di->get("session")->get("account");
        $user->setDb($this->di->get("db"));
        $user->find("username", $username);

        $form = new EditUserForm($this->di, $user);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("user/edit", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    public function getPostCreateUser()
    {
        $title      = "A create user page";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $form       = new CreateUserForm($this->di);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $view->add("user/new", $data);

        $pageRender->renderPage(["title" => $title]);
    }


    public function getPostCreateUserAdmin()
    {
        // Render login page if not logged in.
        if (!$this->di->get("session")->has("account")) {
            $this->di->get("response")->redirect("user/login");
        }

        $title      = "A create user page";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user = new User();
        $username = $this->di->get("session")->get("account");
        $user->setDb($this->di->get("db"));
        $user->find("username", $username);

        if ($user->admin != 1) {
            $this->di->get("response")->redirect("user");
        }

        $form       = new CreateUserAdminForm($this->di);

        $form->check();

        $data = [
            "content" => $form->getHTML(),
        ];

        $view->add("default2/article", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function getPostEditUserAdmin($id)
    {
        // Render login page if not logged in.
        if (!$this->di->get("session")->has("account")) {
            $this->di->get("response")->redirect("user/login");
        }

        $title      = "Edit";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $user = new User();
        $user->setDb($this->di->get("db"));
        $user->find("id", $id);

        $form = new EditUserAdminForm($this->di, $user);

        $form->check();

        $data = [
            "form" => $form->getHTML(),
        ];

        $view->add("user/edit", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    public function getDeleteUserAdmin($id)
    {
        // Render login page if not logged in.
        if (!$this->di->get("session")->has("account")) {
            $this->di->get("response")->redirect("user/login");
        }

        $user = new User();
        $username = $this->di->get("session")->get("account");
        $user->setDb($this->di->get("db"));
        $user->find("username", $username);

        //  Not admin
        if ($user->admin != 1) {
            $this->di->get("response")->redirect("user");
        }

        $userToDelete = new User();
        $userToDelete->setDb($this->di->get("db"));
        $userToDelete->find("id", $id);

        $userToDelete->delete();

        $this->di->get("response")->redirect("user/admin");
    }
}
