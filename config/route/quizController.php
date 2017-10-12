<?php
/**
 * Routes for login
 */
return [
    "routes" => [
        [
            "info" => "Quiz Controller index.",
            "requestMethod" => null,
            "path" => "start",
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
        [
            "info" => "Show the next question in a quiz",
            "requestMethod" => "post",
            "path" => "next",
            "callable" => ["quizController", "incrementQuiz"],
        ],
    ]
];
