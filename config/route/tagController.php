<?php

return [
    "routes" => [
        [
            "info" => "All tags.",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["tagController", "getIndex"],
        ],
    ]
];
