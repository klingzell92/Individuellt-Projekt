<?php
/**
 * Routes for the Quiz server.
 */
return [
    "routes" => [
        [
            "info" => "Get all results for a user",
            "requestMethod" => "get",
            "path" => "{user:alphanum}",
            "callable" => ["quizServerController", "getAllResults"]
        ],
        [
            "info" => "Get all results from a course for a specific user",
            "requestMethod" => "get",
            "path" => "{user:alphanum}/{course:alphanum}",
            "callable" => ["quizServerController", "getResultsFromCourse"]
        ],
        [
            "info" => "Get all results from a test for a specific user",
            "requestMethod" => "get",
            "path" => "{user:alphanum}/{course:alphanum}/{test:alphanum}",
            "callable" => ["quizServerController", "getResultsFromTest"]
        ],
        [
            "info" => "Get one item from the dataset.",
            "requestMethod" => "get",
            "path" => "{dataset:alphanum}/{id:digit}",
            "callable" => ["remController", "getItem"]
        ],
        [
            "info" => "Show a message that the route is unsupported, a local 404.",
            "requestMethod" => null,
            "path" => "**",
            "callable" => ["quizServerController", "anyUnsupported"]
        ],
    ]
];
