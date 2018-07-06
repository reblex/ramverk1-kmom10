<?php

return [
    "routes" => [
        [
            "info" => "Home",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["homeController", "getIndex"],
        ],
    ]
];
