<?php
namespace Anax\View;

use \reblex\User\User;

$allPostsUrl = $this->di->get("url")->create("posts");
$post = $data["post"];
?>

<h1><u>Post #<?= $post->id ?></u></h1>
<br><br>

<a href='<?= $allPostsUrl ?>'>< Back to ALL posts</a>
<br><br>

<?php

$post->printPostHTML($this->di);

echo("<br/><br/>");

if ($data["currentAccount"] != "") {
    $newCommentUrl = url("posts/$post->id/comment");
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

<?php foreach ($data["comments"] as $branch) : ?>
    <?php
    $user = new User;
    $user->setDb($this->di->get("db"));
    $user->find("id", $branch[0]->userId);
    $userUrl = $this->di->get("url")->create("users/$user->username");
    $postId = $post->id;
    $parentCommentId = $branch[0]->id;
    $commentUrl = $this->di->get("url")->create("posts/$postId/comment/$parentCommentId");
    ?>
    <div class="tree">
        <div class="postResponse comment">
            <i><a href="<?=$userUrl?>"><?= $user->username ?></a></i>
            <?= $this->di->get("textfilter")->parse($branch[0]->content, ["markdown"])->text ?>
        </div>
        <div class="subTree">
        <?php foreach (array_slice($branch, 1) as $subComment) : ?>
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
    <i><a class="subReplyLink" href="<?=$commentUrl?>">Reply</a></i>
    <br><br><br>

<?php endforeach; ?>
