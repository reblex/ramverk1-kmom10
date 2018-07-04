<?php

namespace Anax\View;

use reblex\User\User;
?>

<h1><u>Posts</u></h1>
<br><br>

<?php
if ($data["currentAccount"] != "") {
    $newCommentUrl = url("posts/new");
    echo("<a href='$newCommentUrl'>New Post</a>");
} else {
    $loginUrl = url("user/login");
    echo("<a href='$loginUrl'>Log in</a> to discuss!");
}
echo "<br/><br/>";
?>
<img src="" alt="">
<?php
foreach ($data["posts"] as $post) {
    $poster = new User();
    $poster->setDb($this->di->get("db"));
    $poster->find("id", $post->userId);

    $default = "https://www.gravatar.com/avatar/";
    $size = 40;
    $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($poster->email))) . "?d=" . urlencode($default) . "&s=" . $size;
    $username = $poster->username == null ? "(Removed account)" : $poster->username;

    $userBaseUrl = $this->di->get("url")->create("user");

    echo("<div class='post'><div class='poster'><img class='posterImg' src='$grav_url'/><a class='posterName' href='{$userBaseUrl}/$username'>$username</a></div><div class='postText'");

    // find hashtags and convert them to links
    $text = $this->di->get("textfilter")->parse($post->content, ["markdown"])->text;
    $tagBaseUrl = $this->di->get("url")->create("tags");

    $text = preg_replace("/(?:\s|[\.\!\?]+)\#([A-z]+)/", "<a href='{$tagBaseUrl}/$1'> #$1</a>", $text);

    echo("<p style='font-size:20px'>$text</p>");


    echo("</div>");
    echo("<div class='postDetailPanel'>");

    $commentUrl = $this->di->get("url")->create("posts/$post->id");
    echo("<a href='$commentUrl'>Comments</a> ");
    if ($data["currentAccount"] == $poster->username || $data["currentUserRights"] == "admin") {
        $editUrl = url("comments/edit/$post->id");
        $deleteUrl = url("comments/delete/$post->id");
        echo(" | <a href='$editUrl'>Edit</a> | ");
        echo("<a href='$deleteUrl'>Delete</a>");
    }
    echo("</div></div></div");
    echo("<br/><br/>");
}
?>
