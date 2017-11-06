<?php

namespace Anax\QuizServer;

use \Anax\DI\InjectionAwareInterface;
use \Anax\DI\InjectionAwareTrait;
use \Anax\Quiz\Quiz;

/**
 * Quiz Server.
 */
class QuizServer implements InjectionAwareInterface
{
    use InjectionAwareTrait;

    /**
     * Get all results for a user
     *
     * @param string $user to get all tests from
     *
     * @return array with the tests
     */
    public function getAllResultsUser($user)
    {
        $quiz = new Quiz();
        $quiz->setDb($this->di->get("db"));
        $decoded = [];
        $result = $quiz->findAllWhere("acronym = ?", [$user]);
        foreach ($result as $row) {
            foreach ($row as $key => $value) {
                utf8_encode($value);
            }
            $decoded[] = $row;
        }
        //var_dump($decoded);
        $convertResult = json_encode($result);
        $json = json_decode($convertResult);
        return $result;
    }

    /**
     * Get all results from a course
     *
     * @param string $user to get all results from
     * @param string $course to get all results from
     *
     * @return array with the tests
     */
    public function getAllResultsCourse($user, $course)
    {
        $quiz = new Quiz();
        $quiz->setDb($this->di->get("db"));
        $result = $quiz->findAllWhere("acronym = ? and course = ?", [$user, $course]);
        $convertResult = json_encode($result);
        $json = json_decode($convertResult);

        return $json;
    }

    /**
     * Get all results from a test
     *
     * @param string $user to get all tests from
     * @param string $course
     * @param string $test
     *
     * @return array with the tests
     */
    public function getAllResultsTest($user, $course, $test)
    {
        $quiz = new Quiz();
        $quiz->setDb($this->di->get("db"));
        $result = $quiz->findAllWhere("acronym = ? and course = ? and test = ?", [$user, $course, $test]);
        $convertResult = json_encode($result);
        $json = json_decode($convertResult);

        return $json;
    }

    /**
     * Get an item from a dataset.
     *
     * @param string $key    for the dataset
     * @param string $itemId for the item to get
     *
     * @return array|null array with item if found, else null
     */
    public function getItem($key, $itemId)
    {
        $dataset = $this->getDataset($key);

        foreach ($dataset as $item) {
            if ($item["id"] === $itemId) {
                return $item;
            }
        }
        return null;
    }
}
