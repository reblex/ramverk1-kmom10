<?php
    namespace Anax\View;

    $user = $data["user"];
    $default = "https://www.gravatar.com/avatar/";
    $size = 40;
    $grav_url = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($user->email))) . "?d=" . urlencode($default) . "&s=" . $size;
?>
<br>
<br>

<img src="<?= $grav_url ?>" alt="" />

<h1><?= $user->username ?></h1>
<h2><i><?= $user->email ?></i></h2>

<br>

<a href="<?= url("user/edit") ?>">Edit</a> |
<?php
if ($user->admin == 1) {
    $adminLink = url("user/admin");
    echo("<a href='$adminLink'>Admin</a> | ");
}

$logoutLink = url("user/logout");
?>

<a href="<?= $logoutLink?>">Logga ut</a>
