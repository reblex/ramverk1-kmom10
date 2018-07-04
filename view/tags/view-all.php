<?php

namespace Anax\View;

use reblex\User\User;
?>

<h1><u>Tags</u></h1>
<br><br>

<?php

foreach ($data["tags"] as $tag) {
    $url = $this->di->get("url")->create("posts/tag/$tag->name");
    echo "<a href='$url'>$tag->name</a></br>";
}
