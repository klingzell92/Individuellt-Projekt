<?php
/**
 * Routes for login
 */
return [
    "routes" => [
        [
            "info" => "Quiz Controller index.",
            "requestMethod" => null,
            "path" => "quiz",
            "callable" => ["quizController", "getIndex"],
        ],
        [
            "info" => "Login a user.",
            "requestMethod" => "get|post",
            "path" => "login",
            "callable" => ["loginController", "getPostLogin"],
        ],
    ]
];
