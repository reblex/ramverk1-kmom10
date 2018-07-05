<?php

namespace reblex\Post;

use \Anax\Database\ActiveRecordModel;
use \reblex\User\User;

/**
 * Post Model.
 */
class Post extends ActiveRecordModel
{

    protected $tableName = "Post";

    public $id;
    public $userId;
    public $datetime;
    public $content;

    public function printPostHTML($di, $commentButton=false) {
        $poster = new User();
        $poster->setDb($di->get("db"));
        $poster->find("id", $this->userId);

        $default = "https://www.gravatar.com/avatar/";
        $size = 40;
        $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($poster->email))) . "?d=" . urlencode($default) . "&s=" . $size;
        $username = $poster->username == null ? "(Removed account)" : $poster->username;

        $userBaseUrl = $di->get("url")->create("user");

        echo("<div class='post'><div class='poster'><img class='posterImg' src='$grav_url'/><a class='posterName' href='{$userBaseUrl}/$username'>$username</a></div><div class='postText'");

        // find hashtags and convert them to links
        $text = $di->get("textfilter")->parse($this->content, ["markdown"])->text;
        $tagBaseUrl = $di->get("url")->create("tags");

        $text = preg_replace("/(?:\s|[\.\!\?]+)\#([A-z]+)/", "<a href='{$tagBaseUrl}/$1'> #$1</a>", $text);

        echo("<p style='font-size:20px'>$text</p>");


        echo("</div>");
        echo("<div class='postDetailPanel'>");
        if ($commentButton) {
            $commentUrl = $di->get("url")->create("posts/$this->id");
            echo("<a href='$commentUrl'>Comments</a> ");
        }
        echo("</div></div></div");
    }
}
