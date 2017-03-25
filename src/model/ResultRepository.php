<?php

namespace Itb\Model;
use Mattsmithdev\PdoCrudRepo\DatabaseTableRepository;

use Mattsmithdev\PdoCrudRepo\DatabaseManager;

class ResultRepository extends DatabaseTableRepository
{
    public function __construct()
    {
        $namespace = 'Itb\Model';
        $classNameForDbRecords = 'Result';
        $tableName = 'results';
        parent::__construct($namespace, $classNameForDbRecords, $tableName);
    }

    public function resultsByStudentId($studentId)
    {
        $results = $this->getAll();
        $resultsForStudent = [];


        foreach ($results as $result){
            /**
             * @var $result Result
             */
            if($studentId == $result->getId()){
                $resultsForStudent[] = $result;
            }
        }

        return $resultsForStudent;
    }

    public function getAllQuestionResultsForStudent($studentId)
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = '';
        $sql .= 'SELECT studentId, questionId, num1, num2, correctAnswer, studentAnswer, score ';
        $sql .= 'FROM results INNER JOIN questions ON results.questionId = questions.id ';
        $sql .= 'WHERE studentId = :studentId';

        $statement = $connection->prepare($sql);
        $statement->bindParam(':studentId', $studentId, \PDO::PARAM_INT);
        $statement->setFetchMode(\PDO::FETCH_CLASS, '\\Itb\\QuestionResult');
        $statement->execute();

        $products = $statement->fetchAll();

        return $products;

    }


    public function deleteAll()
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = '';
        $sql .= 'DELETE FROM results';

        $statement = $connection->prepare($sql);
        $success = $statement->execute();

        return $success;

    }

    public function resetAutoIncrement()
    {
        $db = new DatabaseManager();
        $connection = $db->getDbh();

        $sql = '';
        $sql .= 'ALTER TABLE results AUTO_INCREMENT = 1';

        $statement = $connection->prepare($sql);
        $success = $statement->execute();

        return $success;
    }

    public function resetDatabaseTable()
    {
        $this->deleteAll();
        $this->resetAutoIncrement();
    }


}