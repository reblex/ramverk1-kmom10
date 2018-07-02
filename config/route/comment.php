<?php

return [
    "routes" => [
        [
            "info" => "Alla kommentarer.",
            "requestMethod" => "get",
            "path" => "comments",
            "callable" => ["commentController", "getIndex"],
        ],
        [
            "info" => "Ny kommentar.",
            "requestMethod" => "get|post",
            "path" => "comments/new",
            "callable" => ["commentController", "getPostNewComment"],
        ],
        [
            "info" => "Edit kommentar.",
            "requestMethod" => "get|post",
            "path" => "comments/edit/{id:digit}",
            "callable" => ["commentController", "getPostEditComment"],
        ],
        [
            "info" => "Delete kommentar.",
            "requestMethod" => "get",
            "path" => "comments/delete/{id:digit}",
            "callable" => ["commentController", "getDeleteComment"],
        ],
    ]
];
