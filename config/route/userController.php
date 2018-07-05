<?php
/**
 * Routes for user controller.
 */
return [
    "routes" => [
        [
            "info" => "User Controller index.",
            "requestMethod" => "get",
            "path" => "user",
            "callable" => ["userController", "getIndex"],
        ],
        [
            "info" => "View all users, as regular user",
            "requestMethod" => "get",
            "path" => "users",
            "callable" => ["userController", "getAllUsers"],
        ],
        [
            "info" => "View specific user, as regular user",
            "requestMethod" => "get",
            "path" => "users/{name:alpha}",
            "callable" => ["userController", "getSpecificUser"],
        ],
        [
            "info" => "User Controller index for Admin.",
            "requestMethod" => "get",
            "path" => "user/admin",
            "callable" => ["userController", "getIndexAdmin"],
        ],
        [
            "info" => "Login a user.",
            "requestMethod" => "get|post",
            "path" => "user/login",
            "callable" => ["userController", "getPostLogin"],
        ],
        [
            "info" => "Logout",
            "requestMethod" => "get",
            "path" => "user/logout",
            "callable" => ["userController", "getLogout"],
        ],
        [
            "info" => "Edit a user",
            "requestMethod" => "get|post",
            "path" => "user/edit",
            "callable" => ["userController", "getPostEditUser"],
        ],
        [
            "info" => "Create a user.",
            "requestMethod" => "get|post",
            "path" => "user/new",
            "callable" => ["userController", "getPostCreateUser"],
        ],
        [
            "info" => "Create a user as admin.",
            "requestMethod" => "get|post",
            "path" => "user/admin/new",
            "callable" => ["userController", "getPostCreateUserAdmin"],
        ],
        [
            "info" => "Edit a user as admin.",
            "requestMethod" => "get|post",
            "path" => "user/admin/edit/{id:digit}",
            "callable" => ["userController", "getPostEditUserAdmin"],
        ],
        [
            "info" => "Delete a user as admin.",
            "requestMethod" => "get",
            "path" => "user/admin/delete/{id:digit}",
            "callable" => ["userController", "getDeleteUserAdmin"],
        ],
    ]
];
