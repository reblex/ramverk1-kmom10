<?php
namespace Anax\View;

$newAccountUrl = url("user/admin/new");
$accountUrl = url("user/");
?>

<h1>Admin</h1>

<p>
    <a href='<?= $newAccountUrl ?>'>Nytt konto</a>
</p>

<h3>Användare</h3>

<table>
    <tr>
        <th>Id</th>
        <th>username</th>
        <th>email</th>
        <th>edit</th>
        <th>delete</th>
    </tr>
    <?php foreach ($data["users"] as $user) : ?>
    <tr>
        <td><?= $user->id ?></td>
        <td><?= $user->username ?></td>
        <td><?= $user->email ?></td>
        <td><a href="<?= url("user/admin/edit/{$user->id}"); ?>">edit</a></td>
        <td><a href="<?= url("user/admin/delete/{$user->id}"); ?>">delete</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<br><br>
<a href="<?= url("user") ?>">Tillbaka till mitt konto</a>
