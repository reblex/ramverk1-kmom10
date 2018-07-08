<?php
    namespace Anax\View;

    $users = $data["users"];
    $posts = $data["posts"];
    $tags  = $data["tags"];

    $default = "https://www.gravatar.com/avatar/";
    $size = 80;
    $baseUserUrl = $this->di->get("url")->create("users");
?>

<h1><u>Home</u></h1>
<br><br>

<div class="statWrapContainer">
    <div class="statContainer statUserContainer">
        <h2>Top 3 most active Users</h2>
        <br>
        <?php foreach ($users as $user) : ?>
        <?php
            $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->email))) . "?d=" . urlencode($default) . "&s=" . $size;
        ?>
        <div class="userHomeContainer">
            <div class="listedUser">
                <img src="<?= $grav_url ?>" alt="" />
                <p class="userDetails">
                    <a class="usernameLink" href="<?= $baseUserUrl?>/<?=$user->username?>"><?= $user->username ?></a>
                    <br>
                    <?=$user->email?>
                </p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="statContainer statPostContainer">
        <h2>Latest Posts</h2>
        <br>
        <?php
        foreach ($data["posts"] as $post) {
            $post->printPostHTML($this->di, true);
            echo("<br><br>");
        }
        ?>
    </div>
    <div class="statContainer statTagContainer">
        <h2>Top 3 most popular Tags</h2>
        <br>
        <?php foreach ($tags as $tag) : ?>
            <h3><a href='<?= $this->di->get('url')->create("posts/tag/$tag->name") ?>'>#<?= $tag->name ?></a></h3>
            <br>
        <?php endforeach; ?>
    </div>
</div>
