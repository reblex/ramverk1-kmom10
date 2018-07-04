<?php

return [
    "routes" => [
        [
            "info" => "All posts.",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["postController", "getIndex"],
        ],
        [
            "info" => "New Post.",
            "requestMethod" => "get|post",
            "path" => "new",
            "callable" => ["postController", "getPostNewPost"],
        ],
        [
            "info" => "Edit Post.",
            "requestMethod" => "get|post",
            "path" => "edit/{id:digit}",
            "callable" => ["postController", "getPostEditPost"],
        ],
        [
            "info" => "Delete Post.",
            "requestMethod" => "get",
            "path" => "delete/{id:digit}",
            "callable" => ["postController", "getDeletePost"],
        ],
    ]
];
