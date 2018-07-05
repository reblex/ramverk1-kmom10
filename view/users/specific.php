<?php
    namespace Anax\View;

    $user = $data["user"];
    $posts = $data["relatedPosts"];
    $default = "https://www.gravatar.com/avatar/";
    $size = 30;
    $baseUserUrl = $this->di->get("url")->create("users");
?>

<h1><u>User: <?= $user->username ?></u></h1>
<br><br>

<?php
    $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->email))) . "?d=" . urlencode($default) . "&s=" . $size;
?>
<div class="listedUser">
    <img src="<?= $grav_url ?>" alt="" />
    <p class="userDetails">
        <a class="usernameLink" href="<?= $baseUserUrl?>/<?=$user->username?>"><?= $user->username ?></a>
        <br>
        <?=$user->email?>
    </p>
</div>

<br><br>
<h2>Post activity</h2>
<i>These posts are either posted by or commented on by <?= $user->username ?>.</i>
<br><br>

<br>

<?php

foreach ($posts as $post) {
    $post->printPostHTML($this->di, true);
    echo("<br><br>");
}
