<?php

namespace Anax\QuizServer;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;

/**
 * A controller for the REM Server.
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
class QuizServerController implements InjectionAwareInterface
{
    use InjectionAwareTrait;


    /**
     * Get all users.
     *
     * @param string $user to get all tests from
     *
     * @return void
     */
    public function getAllResults($user)
    {
        $response = $this->di->get("response");

        $result = $this->di->get("quizServer")->getAllResultsUser($user);
        if (!$result) {
            $response->sendJson(["message" => "Results for $user was not found"]);
            exit;
        }
        $response->sendJson($result);
        exit;
    }


    /**
     * Get all tests for a user from a specific course
     *
     * @param string $user to get tests for
     * @param string $course to get tests from
     *
     * @return void
     */
    public function getResultsFromCourse($user, $course)
    {
        $response = $this->di->get("response");

        $result = $this->di->get("quizServer")->getAllResultsCourse($user, $course);
        if (!$result) {
            $response->sendJson(["message" => "Results for $course was not found"]);
            exit;
        }

        $response->sendJson($result);
        exit;
    }

    /**
     * Get all tests for a user from a specific test
     *
     * @param string $user
     * @param string $course
     * @param string $test
     *
     * @return void
     */
    public function getResultsFromTest($user, $course, $test)
    {
        $response = $this->di->get("response");

        $result = $this->di->get("quizServer")->getAllResultsTest($user, $course, $test);
        if (!$result) {
            $response->sendJson(["message" => "Results for $test was not found"]);
            exit;
        }

        $response->sendJson($result);
        exit;
    }

    /**
     * Show a message that the route is unsupported, a local 404.
     *
     * @return void
     */
    public function anyUnsupported()
    {
        $this->di->get("response")->sendJson(["message" => "404. The api/ does not support that."], 404);
        exit;
    }
}
