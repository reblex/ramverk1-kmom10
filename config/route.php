<?php

use \Anax\Route\Router;

/**
 * Configuration file for routes.
 */
return [
    //"mode" => Router::DEVELOPMENT, // default, verbose execeptions
    //"mode" => Router::PRODUCTION,  // exceptions turn into 500

    // Load these routefiles in order specified and optionally mount them
    // onto a base route.
    "routeFiles" => [
        [
            // Add routes from userController and mount on user/
            "mount" => "",
            "file" => __DIR__ . "/route/other.php",
        ],
        [
            // These are for internal error handling and exceptions
            "mount" => null,
            "file" => __DIR__ . "/route/internal.php",
        ],
        [
            // For development, learning, testing and debugging Anax
            "mount" => "dev",
            "file" => __DIR__ . "/route/dev.php",
        ],
        [
            // For debugging and development details on Anax
            "mount" => "debug",
            "file" => __DIR__ . "/route/debug.php",
        ],
        [
            // Add routes from userController and mount on user/
            "mount" => null,
            "file" => __DIR__ . "/route/userController.php",
        ],
        [
            // Add routes from userController and mount on user/
            "mount" => "posts",
            "file" => __DIR__ . "/route/postController.php",
        ],
        [
            // Add routes from userController and mount on user/
            "mount" => "tags",
            "file" => __DIR__ . "/route/tagController.php",
        ],
        [
            // To read flat file content in Markdown from content/
            "mount" => null,
            "file" => __DIR__ . "/route/flat-file-content.php",
        ],
        [
            // Keep this last since its a catch all
            "mount" => null,
            "sort" => 999,
            "file" => __DIR__ . "/route/404.php",
        ],
    ],

];
