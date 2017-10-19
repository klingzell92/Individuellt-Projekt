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
            "info" => "Add test to db and render result page",
            "requestMethod" => "get|post",
            "path" => "handle",
            "callable" => ["quizController", "handlePostQuiz"],
        ],
        [
            "info" => "Show the test",
            "requestMethod" => "get",
            "path" => "result/{user:alphanum}/{course:alphanum}/{test:alphanum}",
            "callable" => ["quizController", "showResult"],
        ],
        [
            "info" => "Show the next question in a quiz",
            "requestMethod" => "post",
            "path" => "next",
            "callable" => ["quizController", "incrementQuiz"],
        ],
        [
            "info" => "Show the previous question in a quiz",
            "requestMethod" => "get",
            "path" => "previous/{course:alphanum}/{test:alphanum}",
            "callable" => ["quizController", "decrementQuiz"],
        ],
    ]
];
