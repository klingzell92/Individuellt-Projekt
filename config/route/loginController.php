<?php
/**
 * Routes for login
 */
return [
    "routes" => [
        [
            "info" => "User Controller index.",
            "requestMethod" => "get",
            "path" => "profile",
            "callable" => ["userController", "getIndex"],
        ],
        [
            "info" => "Login a user.",
            "requestMethod" => "get|post",
            "path" => "login",
            "callable" => ["loginController", "getPostLogin"],
        ],
    ]
];
