<?php

namespace reblex\Tag;

use \Anax\Configure\ConfigureInterface;
use \Anax\Configure\ConfigureTrait;
use \Anax\DI\InjectionAwareInterface;
use \Anax\Di\InjectionAwareTrait;
use \reblex\Tag\Tag;
use \reblex\Post\Post;
use \reblex\PostTag\PostTag;

/**
 * A controller class.
 */
class TagController implements
    ConfigureInterface,
    InjectionAwareInterface
{
    use ConfigureTrait,
        InjectionAwareTrait;



    /**
     * @var $data description
     */
    //private $data;



    /**
     * Show all items.
     *
     * @return void
     */
    public function getIndex()
    {
        $title      = "Tags";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $tag = new Tag();
        $tag->setDb($this->di->get("db"));

        $data = [
            "tags" => $tag->findAll()
        ];

        $view->add("tags/view-all", $data);

        $pageRender->renderPage(["title" => $title]);
    }

    /**
     * Show all items.
     *
     * @return void
     */
    public function getSpecific($name)
    {
        $title      = "#$name";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");

        $account = $this->di->get("session")->get("account") ?: "";
        $currentUserRights = "none";

        if ($account != "") {
            $user = new User();
            $user->setDb($this->di->get("db"));
            $user->find("username", $account);
            $currentUserRights = $user->admin == 1 ? "admin" : "user";
        }

        // Get the tag
        $tag = new Tag();
        $tag->setDb($this->di->get("db"));
        $tag->find("name", $name);

        // Get the PostTag links with the tagId
        $postTags = new PostTag();
        $postTags->setDb($this->di->get("db"));
        $postTags = $postTags->findAllWhere("tagId = ?", $tag->id);

        // Find all posts with postIds linked to
        // the tagId using the PostTag links.
        $posts = [];
        foreach ($postTags as $pt) {
            $post = new Post();
            $post->setDb($this->di->get("db"));
            $post->find("id", $pt->postId);
            array_push($posts, $post);
        }

        $data = [
            "posts" => $posts,
            "currentAccount" => $account,
            "currentUserRights" => $currentUserRights,
            "tagName" => $tag->name
        ];

        $view->add("posts/view-all", $data);

        $pageRender->renderPage(["title" => $title]);
    }
}
