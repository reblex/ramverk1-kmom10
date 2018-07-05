<?php

namespace Anax\View;

use reblex\User\User;
?>

<h1><u>Posts</u></h1>
<br><br>

<?php
if (isset($data["tagName"])) {
    $allPostsUrl = $this->di->get("url")->create("posts");
    echo("<p>Viewing all posts for the tag #{$data["tagName"]}</br>");
    echo("<a href='$allPostsUrl'>View ALL posts</a></p>");
}

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
    $post->printPostHTML($this->di, true);
    echo("<br><br>");
}
?>
