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
            "info" => "Show the test",
            "requestMethod" => "get",
            "path" => "quiz/{course:alphanum}/{test:alphanum}",
            "callable" => ["quizController", "showTest"],
        ],
        [
            "info" => "Get result from test",
            "requestMethod" => "get|post",
            "path" => "result",
            "callable" => ["quizController", "handlePostQuiz"],
        ],
    ]
];
