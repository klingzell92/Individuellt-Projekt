<?php
/**
 * Routes for login
 */
return [
    "routes" => [
        [
            "info" => "Quiz Controller index.",
            "requestMethod" => null,
            "path" => "index",
            "callable" => ["quizController", "getIndex"],
        ],
        [
            "info" => "Login a user.",
            "requestMethod" => "get|post",
            "path" => "login",
            "callable" => ["loginController", "getPostLogin"],
        ],
        [
            "info" => "Show the test",
            "requestMethod" => "get",
            "path" => "quiz/{course:alphanum}/{test:alphanum}",
            "callable" => ["quizController", "showTest"],
        ],
    ]
];
