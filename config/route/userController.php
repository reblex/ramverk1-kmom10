<?php
/**
 * Routes for user controller.
 */
return [
    "routes" => [
        [
            "info" => "User Controller index.",
            "requestMethod" => "get",
            "path" => "",
            "callable" => ["userController", "getIndex"],
        ],
        [
            "info" => "User Controller index for Admin.",
            "requestMethod" => "get",
            "path" => "admin",
            "callable" => ["userController", "getIndexAdmin"],
        ],
        [
            "info" => "Login a user.",
            "requestMethod" => "get|post",
            "path" => "login",
            "callable" => ["userController", "getPostLogin"],
        ],
        [
            "info" => "Logout",
            "requestMethod" => "get",
            "path" => "logout",
            "callable" => ["userController", "getLogout"],
        ],
        [
            "info" => "Edit a user",
            "requestMethod" => "get|post",
            "path" => "edit",
            "callable" => ["userController", "getPostEditUser"],
        ],
        [
            "info" => "Create a user.",
            "requestMethod" => "get|post",
            "path" => "new",
            "callable" => ["userController", "getPostCreateUser"],
        ],
        [
            "info" => "Create a user as admin.",
            "requestMethod" => "get|post",
            "path" => "admin/new",
            "callable" => ["userController", "getPostCreateUserAdmin"],
        ],
        [
            "info" => "Edit a user as admin.",
            "requestMethod" => "get|post",
            "path" => "admin/edit/{id:digit}",
            "callable" => ["userController", "getPostEditUserAdmin"],
        ],
        [
            "info" => "Delete a user as admin.",
            "requestMethod" => "get",
            "path" => "admin/delete/{id:digit}",
            "callable" => ["userController", "getDeleteUserAdmin"],
        ],
    ]
];
