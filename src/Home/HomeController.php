<?php

namespace reblex\Home;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \reblex\User\User;
use \reblex\Comment\Comment;
use \reblex\Post\Post;
use \reblex\Tag\Tag;
use \reblex\PostTag\PostTag;

/**
 * Post Controller.
 */
class HomeController implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
     * Show all items.
     *
     * @return void
     */
    public function getIndex()
    {
        $title      = "Home";
        $view       = $this->di->get("view");
        $pageRender = $this->di->get("pageRender");
        $db = $this->di->get("db");
        $db->connect();


        // Get the 3 latest posts
        $sql = "SELECT * FROM (
                    SELECT * FROM Post ORDER BY `datetime` DESC LIMIT 3
                ) as r ORDER BY `datetime`";
        $latestPosts = $db->executeFetchAll($sql);

        // Get the ids of the latest posts.
        // Do it backwards so newest is on [0].
        $latestPostIds = [];
        for ($i=count($latestPosts) - 1; $i >= 0; $i--) {
            array_push($latestPostIds, $latestPosts[$i]->id);
        }

        $posts = [];
        foreach ($latestPostIds as $id) {
            $post = new Post();
            $post->setDb($db);
            $post->find("id", $id);
            array_push($posts, $post);
        }


        // Get the 3 most popular tags
        $sql = "SELECT tagId, COUNT(*) AS magnitude
                FROM PostTag
                GROUP BY tagId
                ORDER BY magnitude DESC
                LIMIT 3";
        $popTags = $db->executeFetchAll($sql);

        $tags = [];
        foreach ($popTags as $pt) {
            $tag = new Tag();
            $tag->setDb($db);
            $tag->find("id", $pt->tagId);
            array_push($tags, $tag);
        }

        // Get top 3 users with most combined Posts/Comments
        $sql = "SELECT User.id, IFNULL(pCount, 0) + IFNULL(cCount, 0) AS count
                FROM User
                LEFT JOIN(
                    SELECT userId, COUNT(*) as pCount
                    FROM Post
                    GROUP BY userId
                ) posts ON User.id=posts.userId
                LEFT JOIN(
                    SELECT userId, COUNT(*) as cCount
                    FROM Comment
                    GROUP BY userId
                ) comments ON User.id=comments.userId
                ORDER BY count DESC LIMIT 3";


        $popUsers = $db->executeFetchAll($sql);

        $users = [];
        foreach ($popUsers as $pu) {
            $user = new User();
            $user->setDb($db);
            $user->find("id", $pu->id);
            array_push($users, $user);
        }


        $data = [
            "users" => $users,
            "posts" => $posts,
            "tags" => $tags,

        ];

        $view->add("home", $data);

        $pageRender->renderPage(["title" => $title]);
    }
}
