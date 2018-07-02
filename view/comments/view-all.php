<?php
namespace Anax\View;

use reblex\User\User;
?>

<h1><u>Kommentarer</u></h1>
<br><br>

<?php
if ($data["currentAccount"] != "") {
    $newCommentUrl = url("comments/new");
    echo("<a href='$newCommentUrl'>Ny Kommentar</a>");
} else {
    $loginUrl = url("user/login");
    echo("<a href='$loginUrl'>Logga in</a> för att kommentera.");
}
echo "<br/><br/>";
?>

<?php
foreach ($data["comments"] as $comment) {
    $commenter = new User();
    $commenter->setDb($this->di->get("db"));
    $commenter->find("id", $comment->userId);

    $username = $commenter->username == null ? "(Removed account)" : $commenter->username;

    echo("<div style='border: solid 2px gray; padding:5px; max-width: 400px;'><i style='font-size:20px'>$username</i>");
    echo("<p style='font-size:20px'>{$comment->content}</p>");

    if ($data["currentAccount"] == $commenter->username || $data["currentUserRights"] == "admin") {
        $editUrl = url("comments/edit/$comment->id");
        $deleteUrl = url("comments/delete/$comment->id");
        echo("<a href='$editUrl'>Edit</a> ");
        echo("<a href='$deleteUrl'>Delete</a>");
    }
    echo("</div>");
    echo("<br/><br/>");
}
?>
