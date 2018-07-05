<?php
namespace Anax\View;

use \reblex\User\User;

$allPostsUrl = $this->di->get("url")->create("posts");
?>

<h1><u>Post #<?= $data["post"]->id ?></u></h1>
<br><br>

<a href='<?= $allPostsUrl ?>'>< Back to ALL posts</a>
<br><br>

<?php
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

echo("</div></div></div");
echo("<br/><br/>");

if ($data["currentAccount"] != "") {
    $newCommentUrl = url("posts/new");
    echo("<a href='$newCommentUrl'>Reply to this Post</a>");
} else {
    $loginUrl = url("user/login");
    echo("<a href='$loginUrl'>Log in</a> to discuss this post!");
}
echo "<br/><br/>";

// var_dump($data["comments"]);

echo("<h3>Comments</h3>");

if (count($data["comments"]) == 0) {
    echo("<i>There are no comments on this post, be the first one!</i>");
}
?>

<br>

<?php foreach($data["comments"] as $branch): ?>
    <?php
    $user = new User;
    $user->setDb($this->di->get("db"));
    $user->find("id", $branch[0]->userId);
    $userUrl = $this->di->get("url")->create("users/$user->username");
    ?>
    <div class="tree">
        <div class="postResponse comment">
            <i><a href="<?=$userUrl?>"><?= $user->username ?></a></i>
            <?= $this->di->get("textfilter")->parse($branch[0]->content, ["markdown"])->text ?>
        </div>
        <div class="subTree">
        <?php foreach(array_slice($branch,1) as $subComment): ?>
        <?php
            $user = new User;
            $user->setDb($this->di->get("db"));
            $user->find("id", $subComment->userId);
            $userUrl = $this->di->get("url")->create("users/$user->username");
        ?>
            <div class="subComment comment">
                <i><a href="<?=$userUrl?>"><?= $user->username ?></a></i>
                <?= $this->di->get("textfilter")->parse($subComment->content, ["markdown"])->text ?>
            </div>

        <?php endforeach; ?>
        </div>
    </div>

<?php endforeach; ?>
