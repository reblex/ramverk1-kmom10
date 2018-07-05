<?php
    namespace Anax\View;

    $users = $data["users"];
    $default = "https://www.gravatar.com/avatar/";
    $size = 30;
    $baseUserUrl = $this->di->get("url")->create("users");
?>

<h1><u>Users</u></h1>
<br><br>

<?php foreach($users as $user): ?>
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
<?php endforeach; ?>
