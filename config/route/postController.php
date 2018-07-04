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
            "info" => "All posts for specific tag.",
            "requestMethod" => "get",
            "path" => "tag/{name:alpha}",
            "callable" => ["tagController", "getSpecific"],
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
